<div>

    <div class="row">
        @if($show)
            <div class="col-lg-12 col-md-12">

                <h4 class="card-title mb-4">Rules Commissions
                    @if(\session()->get('url')!='profile')

                        @if(!$duplicate)
                            <button type="button" class="btn btn-sm btn-warning  waves-effect waves-light  me-2 float-end" wire:click.prevent="toggleDuplicate"> <i class="bx bx-add-to-queue font-size-16 align-middle "></i> Duplicate All</button>
                            <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="toggleShowRules"> <i class="bx bx-plus font-size-16 align-middle "></i> New</button>
                        @else

                        @endif
                    @endif
                </h4>
                @if($duplicate)
                    <div class="row">
                        <div class="col-lg-8 col-md-8"></div>
                        <div class="col-lg-4 col-md-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Technician</label>
                                    <select class="form-control"
                                            name="tech_id" wire:model="tech_id" data-placeholder="Select ...">
                                        <option selected >chose...</option>
                                        @foreach($techs as $tech)
                                            <option  value="{{$tech->id}}">{{$tech->user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('tech_id')
                                <div class="invalid-feedback show">
                                    Please select a report valid option.
                                </div>
                                @enderror
                                    <button type="button" class="btn btn-sm btn-success  waves-effect waves-light  me-2 float-end" wire:click.prevent="duplicate" {{isset($tech_id) ? '' : 'disabled' }}> <i class="bx bx-add-to-queue font-size-16 align-middle "></i> Duplicate</button>

                            </div>
                        </div>
                    </div>
                @endif
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
