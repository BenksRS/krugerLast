<div>

    <div class="row">
        <div class="col-lg-4">
            @livewire('car::list.show.tabs.info.general', ['car' => $car->id], key('info_general'))
        </div>
        <div class="col-lg-4">
            @livewire('car::list.show.tabs.info.insurance', ['car' => $car->id], key('info_insurance'))
            @livewire('car::list.show.tabs.info.loan', ['car' => $car->id], key('info_loan'))

        </div>
        <div class="col-lg-4">
            @livewire('car::list.show.tabs.info.notes', ['car' => $car->id], key('info_notes'))
        </div>
    </div>

</div>
