<?php

namespace Modules\Gdrive\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Gdrive\Entities\LabelingExample;

class LabelingKbController extends Controller
{
    /** Grupos de usuário com acesso */
    public const ALLOWED_GROUPS = [1, 4];

    public function __construct()
    {
        $this->middleware('auth:user');
        $this->middleware(function ($request, $next) {
            $groupId = (int) optional($request->user())->group_id;
            abort_unless(in_array($groupId, self::ALLOWED_GROUPS, true), 403, 'Sem acesso ao Labeling.');

            return $next($request);
        });
    }

    public function index()
    {
        $page = (object) [
            'title' => 'Labeling — AI Knowledge Base',
            'back' => url('/'),
            'back_title' => 'Home',
        ];
        session()->flash('page', $page);

        return view('gdrive::labeling', compact('page'));
    }

    public function exampleImage($id)
    {
        $example = LabelingExample::findOrFail($id);
        abort_unless(is_file($example->absolutePath()), 404);

        return response()->file($example->absolutePath());
    }
}
