<?php

namespace Modules\Assignments\Http\Livewire\Show;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Auth;

class TabsPanel extends Component
{

    protected $listeners = [
        'changeTab' => 'processChangetab',
    ];

    public $assignment;
    public $isActive = 'info-details';

    public $navs = [
        [
            'title' => 'Info Details',
            'status' => 'active',
            'href' => 'info-details',
            'key' => 'assignments_tab_info',
            'tab' => 'assignments::show.tabs.info',
            'category' => 'all',
        ],
        [
            'title' => 'Job Report',
            'status' => '',
            'href' => 'job-report',
            'key' => 'assignments_tab_jobreports',
            'tab' => 'assignments::show.tabs.job-reports',
            'category' => 'all',
        ],
        [
            'title' => 'Gallery',
            'status' => '',
            'href' => 'gallery',
            'key' => 'assignments_tab_gallery',
            'tab' => 'assignments::show.tabs.gallery',
            'category' => 'all',
        ],
        [
            'title' => 'Forms',
            'status' => '',
            'href' => 'forms',
            'key' => 'assignments_tab_forms',
            'tab' => 'assignments::show.tabs.forms',
            'category' => 'all',
        ],
        [
            'title' => 'Finance',
            'status' => '',
            'href' => 'finance',
            'key' => 'assignments_tab_finance',
            'tab' => 'assignments::show.tabs.finance',
            'category' => 'all',
        ],
        [
            'title' => 'Comissions',
            'status' => '',
            'href' => 'comissions',
            'key' => 'assignments_tab_comissions',
            'tab' => 'assignments::show.tabs.comissions',
            'category' => 1,
        ],
//        [
//            'title' => 'Coasts',
//            'status' => '',
//            'href' => 'coasts',
//            'key' => 'assignments_tab_coasts',
//            'tab' => 'assignments::show.tabs.coasts',
//            'category' => 'all',
//        ],
//        [
//            'title' => 'Messages',
//            'status' => '',
//            'href' => 'messages',
//            'key' => 'assignments_tab_messages',
//            'tab' => 'assignments::show.tabs.messages',
//            'category' => 'all',
//        ],

    ];
    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->user = Auth::user();

        $this->checkTabActive();
    }

    public function checkTabActive(){
        switch ($this->assignment->status_id){
            case 4:
            case 5:
            case 10:
            case 24:
                $this->isActive = 'finance';
                break;
            case 29:
            case 14:
                $this->isActive = 'forms';
            break;
            default:
                $this->isActive = 'info-details';
                break;
        }
    }
    public function processChangetab($newActive)
    {

        $this->isActive = $newActive;

    }
    public function render()
    {
        return view('assignments::livewire.show.tabs-panel');
    }
}
