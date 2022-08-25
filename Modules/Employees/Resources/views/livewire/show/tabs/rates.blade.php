<div>

    <div class="row">
        @if($show)
            <div class="col-lg-12 col-md-12">
                <h4 class="card-title mb-4">Daily Rates
                    <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="toggleShowRates"> <i class="bx bx-file font-size-16 align-middle "></i> Edit</button>
                </h4>

                @livewire('employees::show.tabs.rates.show', ['user' => $user->id], key('employees_tab_rates_show'))
            </div>
        @else
            <div class="col-lg-12 col-md-12">
                <h4 class="card-title mb-4">Daily Rates Edit

                    <button type="button" class="btn btn-sm btn-secondary  waves-effect waves-light  me-2 float-end" wire:click.prevent="toggleShowRates"> <i class="fas fa-chevron-left font-size-16 align-middle "></i> Back</button>
                </h4>
                @livewire('employees::show.tabs.rates.edit', ['user' => $user->id], key('employees_tab_rates_edit'))
            </div>
        @endif
    </div>
</div>
