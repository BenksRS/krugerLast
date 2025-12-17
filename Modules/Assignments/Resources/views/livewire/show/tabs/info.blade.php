<div>
    <div class="row">
        <div class="col-lg-4">
            @livewire('assignments::show.tabs.info.address', ['assignment' => $assignment->id], key('assignment_tabs_info_address'))
            @livewire('assignments::show.tabs.info.phones', ['assignment' => $assignment->id], key('assignment_tabs_info_phone'))
            @livewire('assignments::show.tabs.info.links', ['assignment' => $assignment->id], key('assignment_tabs_info_links'))
        </div>
        <div class="col-lg-4">
            @livewire('assignments::show.tabs.info.referral-info', ['assignment' => $assignment->id], key('assignment_tabs_info_referral-info'))
        </div>
        <div class="col-lg-4">
            @livewire('assignments::show.tabs.info.notes', ['assignment' => $assignment->id], key('assignment_tabs_info_notes'))
        </div>
    </div>
</div>