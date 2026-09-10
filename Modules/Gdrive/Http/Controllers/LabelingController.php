<?php

namespace Modules\Gdrive\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsStatus;
use Modules\Gdrive\Entities\QueeLabeling;
use Modules\Gdrive\Services\Labeling\LabelingService;

class LabelingController extends Controller
{
    /**
     * Enfileira jobs que estão no status `labeling` e ainda não têm run ativo.
     * Cron sugerido: a cada 5 min.
     */
    public function add_queue_labeling()
    {
        $statusId = AssignmentsStatus::where('class', 'labeling')->value('id');
        if (!$statusId) {
            return response()->json(['error' => 'status labeling inexistente'], 500);
        }

        $active = ['pending', 'processing', 'awaiting_ai'];
        $added = 0;

        foreach (Assignment::where('status_id', $statusId)->pluck('id') as $assignmentId) {
            $hasActive = QueeLabeling::where('assignment_id', $assignmentId)
                ->whereIn('status', $active)
                ->exists();
            if ($hasActive) {
                continue;
            }

            QueeLabeling::create([
                'assignment_id' => $assignmentId,
                'order' => 50,
                'status' => 'pending',
                'history' => '<b># Enfileirado:</b> ' . Carbon::now(),
            ]);
            $added++;
        }

        return response()->json(['queued' => $added]);
    }

    /**
     * Processa 1 job pendente: baixa fotos, deduplica, envia o batch pra IA.
     * Cron sugerido: a cada 2 min.
     */
    public function queue_labeling()
    {
        // libera runs travados
        QueeLabeling::where('status', 'processing')
            ->where('updated_at', '<', Carbon::now()->subMinutes(45))
            ->update(['status' => 'error', 'history' => 'run travado em processing — liberado']);

        if (QueeLabeling::where('status', 'processing')->exists()) {
            return response()->json(['skipped' => 'já há um run em processing']);
        }

        $queue = QueeLabeling::where('status', 'pending')->orderBy('order')->orderBy('id')->first();
        if (!$queue) {
            return response()->json(['idle' => true]);
        }

        $queue->update(['status' => 'processing']);

        try {
            app(LabelingService::class)->prepare($queue);
        } catch (\Throwable $e) {
            Log::error('[labeling] prepare ' . $queue->id . ': ' . $e->getMessage());
            $queue->refresh();
            app(LabelingService::class)->log($queue, 'ERRO: ' . $e->getMessage());
            $queue->update(['status' => 'error']);

            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['prepared' => $queue->id, 'batch_id' => $queue->fresh()->batch_id]);
    }

    /**
     * Coleta resultados dos batches prontos, carimba as fotos, sobe no Drive
     * e move o job pro próximo status.
     * Cron sugerido: a cada 2 min.
     */
    public function poll_labeling()
    {
        $limit = (int) config('gdrive.labeling.poll_batch_size', 3);
        $done = [];
        $waiting = [];
        $errored = [];

        $queues = QueeLabeling::where('status', 'awaiting_ai')->orderBy('id')->limit($limit)->get();

        foreach ($queues as $queue) {
            try {
                app(LabelingService::class)->finalize($queue);
                $queue->refresh();
                $queue->status === 'complete' ? $done[] = $queue->id : $waiting[] = $queue->id;
            } catch (\Throwable $e) {
                Log::error('[labeling] finalize ' . $queue->id . ': ' . $e->getMessage());
                $queue->refresh();
                app(LabelingService::class)->log($queue, 'ERRO: ' . $e->getMessage());
                $queue->update(['status' => 'error']);
                $errored[] = $queue->id;
            }
        }

        return response()->json(compact('done', 'waiting', 'errored'));
    }
}
