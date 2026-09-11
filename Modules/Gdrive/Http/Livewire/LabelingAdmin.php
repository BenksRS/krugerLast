<?php

namespace Modules\Gdrive\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Gdrive\Entities\LabelingBanned;
use Modules\Gdrive\Entities\LabelingExample;
use Modules\Gdrive\Entities\LabelingRule;
use Modules\Gdrive\Entities\LabelingVocabulary;

class LabelingAdmin extends Component
{
    use WithFileUploads;

    public $tab = 'examples';

    // rules
    public $ruleSection = 'General';
    public $ruleBody = '';

    // vocabulary
    public $vocabCategory = '';
    public $vocabTerm = '';

    // banned
    public $bannedTerm = '';

    // example
    public $exImage;
    public $exDescription = '';
    public $exCategory = '';
    public $exNote = '';
    public $exJob = '';

    protected $tabs = ['examples', 'rules', 'vocabulary', 'banned'];

    public function setTab($tab): void
    {
        if (in_array($tab, $this->tabs, true)) {
            $this->tab = $tab;
        }
    }

    protected function uid(): ?int
    {
        return optional(Auth::user())->id;
    }

    /* ------------------------------------------------------------ rules */

    public function addRule(): void
    {
        $this->validate([
            'ruleSection' => 'required|string|max:60',
            'ruleBody' => 'required|string|max:2000',
        ]);

        LabelingRule::create([
            'section' => trim($this->ruleSection) ?: 'General',
            'body' => trim($this->ruleBody),
            'active' => true,
            'sort' => (int) LabelingRule::max('sort') + 10,
            'created_by' => $this->uid(),
        ]);

        $this->reset('ruleBody');
        $this->dispatchBrowserEvent('saved');
    }

    public function toggleRule(int $id): void
    {
        $rule = LabelingRule::find($id);
        if ($rule) {
            $rule->update(['active' => !$rule->active]);
        }
    }

    public function deleteRule(int $id): void
    {
        LabelingRule::where('id', $id)->delete();
    }

    /* ------------------------------------------------------- vocabulary */

    public function addVocab(): void
    {
        $this->validate([
            'vocabCategory' => 'required|string|max:80',
            'vocabTerm' => 'required|string|max:160',
        ]);

        LabelingVocabulary::create([
            'category' => trim($this->vocabCategory),
            'term' => trim($this->vocabTerm),
            'active' => true,
            'sort' => (int) LabelingVocabulary::max('sort') + 10,
            'created_by' => $this->uid(),
        ]);

        $this->reset('vocabTerm');
        $this->dispatchBrowserEvent('saved');
    }

    public function toggleVocab(int $id): void
    {
        $row = LabelingVocabulary::find($id);
        if ($row) {
            $row->update(['active' => !$row->active]);
        }
    }

    public function deleteVocab(int $id): void
    {
        LabelingVocabulary::where('id', $id)->delete();
    }

    /* ----------------------------------------------------------- banned */

    public function addBanned(): void
    {
        $this->validate(['bannedTerm' => 'required|string|max:120']);

        LabelingBanned::firstOrCreate(
            ['term' => trim($this->bannedTerm)],
            ['active' => true, 'created_by' => $this->uid()]
        );

        $this->reset('bannedTerm');
        $this->dispatchBrowserEvent('saved');
    }

    public function deleteBanned(int $id): void
    {
        LabelingBanned::where('id', $id)->delete();
    }

    /* --------------------------------------------------------- examples */

    public function addExample(): void
    {
        $this->validate([
            'exImage' => 'required|image|mimes:jpeg,jpg,png|max:12288',
            'exDescription' => 'required|string|max:160',
            'exCategory' => 'required|string|max:80',
            'exNote' => 'nullable|string|max:2000',
            'exJob' => 'nullable|string|max:30',
        ]);

        $path = $this->exImage->store('labeling-kb/examples', 'local');

        LabelingExample::create([
            'image_path' => $path,
            'description' => trim($this->exDescription),
            'category' => trim($this->exCategory),
            'note' => trim($this->exNote) ?: null,
            'job_number' => trim($this->exJob) ?: null,
            'active' => true,
            'created_by' => $this->uid(),
        ]);

        $this->reset(['exImage', 'exDescription', 'exCategory', 'exNote', 'exJob']);
        $this->dispatchBrowserEvent('saved');
    }

    public function toggleExample(int $id): void
    {
        $ex = LabelingExample::find($id);
        if ($ex) {
            $ex->update(['active' => !$ex->active]);
        }
    }

    public function deleteExample(int $id): void
    {
        $ex = LabelingExample::find($id);
        if ($ex) {
            $ex->deleteFile();
            $ex->delete();
        }
    }

    /* ---------------------------------------------------------- render */

    public function render()
    {
        $categories = LabelingVocabulary::query()
            ->select('category')->distinct()->orderBy('category')->pluck('category');

        return view('gdrive::livewire.labeling-admin', [
            'rules' => LabelingRule::orderBy('section')->orderBy('sort')->orderBy('id')->get()->groupBy('section'),
            'vocab' => LabelingVocabulary::orderBy('category')->orderBy('sort')->orderBy('id')->get()->groupBy('category'),
            'banned' => LabelingBanned::orderBy('term')->get(),
            'examples' => LabelingExample::orderByDesc('id')->get(),
            'categories' => $categories,
        ]);
    }
}
