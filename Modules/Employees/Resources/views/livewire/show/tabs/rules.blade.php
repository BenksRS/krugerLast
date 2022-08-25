<div>

    <div class="row">
        @if($show)
            <div class="col-lg-12 col-md-12">
                <h4 class="card-title mb-4">Rules Commissions
                    <button type="button" class="btn btn-sm btn-warning  waves-effect waves-light  me-2 float-end" wire:click.prevent="duplicate"> <i class="bx bx-add-to-queue font-size-16 align-middle "></i> Duplicate All</button>
                    <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="toggleShowRules"> <i class="bx bx-plus font-size-16 align-middle "></i> New</button>

                </h4>

                @livewire('employees::show.tabs.rules.show', ['user' => $user->id], key('employees_tab_rules_show'))
            </div>
        @else
            <div class="col-lg-12 col-md-12">
                <h4 class="card-title mb-4">New Rule Commissions

                    <button type="button" class="btn btn-sm btn-secondary  waves-effect waves-light  me-2 float-end" wire:click.prevent="toggleShowRules"> <i class="fas fa-chevron-left font-size-16 align-middle "></i> Back to List</button>
                </h4>
                @livewire('employees::show.tabs.rules.add', ['user' => $user->id], key('employees_tab_rules_add'))
            </div>
        @endif
    </div>
</div>
