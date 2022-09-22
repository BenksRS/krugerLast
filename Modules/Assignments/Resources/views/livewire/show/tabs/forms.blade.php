<div>
    <div class="row">
        <div class="col-lg-4">
            @livewire('assignments::show.tabs.forms.lists', ['assignment' => $assignment->id], key('assignment_show_form_lists'))
        </div>
        <div class="col-lg-4">
            @livewire('assignments::show.tabs.forms.doscusign', ['assignment' => $assignment->id], key('assignment_show_form_lists'))
        </div>
        <div class="col-lg-4">
            @livewire('assignments::show.tabs.forms.sign', ['assignment' => $assignment->id], key('assignment_show_form_sign'))

        </div>
    </div>
</div>
