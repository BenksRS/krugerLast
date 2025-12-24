<div>

    <h4 class="card-title mb-4">General Information
        @if($show)<button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="$emit('editGeneral')"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</button>@endif
    </h4>

    @if(session()->has('alert'))
        <div  class="alert alert-{{session('alert')['class']}}" x-init="setTimeout(() => show = false, 3000)">
            {{session('alert')['message']}}
        </div>
        <script>
            setTimeout(function() {
                $('.alert').fadeOut('fast');
            }, 2000);
        </script>
    @endif

    <div class="card">
        <div class="card-body">
            @if($show)
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                        <tr>
                            <th scope="row">Make:</th>
                            <td>{{$car->make}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Model:</th>
                            <td>{{$car->model}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Year:</th>
                            <td>{{$car->year}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Plate:</th>
                            <td>{{$car->plate}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Vin number:</th>
                            <td>{{$car->vin}}</td>
                        </tr>
                        <tr>
                            <th scope="row">E-pass:</th>
                            <td>{{$car->epass}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tag Expires:</th>
                            <td>{{$car->tag_expires}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Created:</th>
                            <td><h5 class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i> - </h5></td>
                        </tr>
                        <tr>
                            <th scope="row">Last Update:</th>
                            <td><h5 class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i> - </h5></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            @else
{{--     EDIT    --}}

                <form class="needs-validation  was-validated" action="" wire:submit.prevent.lazy="update(Object.fromEntries(new FormData($event.target)))"  novalidate>
                    <div class="row">

                        <div class="col-md-12">
                            <label  class="form-label mt-2">Make:</label>
                            <input type="text" class="form-control "  name="make"
                                   placeholder="Make..." wire:model="make" >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('make')
                            <div class="invalid-feedback">
                                Please type Make.
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-12">
                            <label  class="form-label mt-2">Model:</label>
                            <input type="text" class="form-control "  name="model"
                                   placeholder="Model..." wire:model="model"  >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('model')
                            <div class="invalid-feedback">
                                Please type Model.
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-12">
                            <label  class="form-label mt-2">Year:</label>
                            <input type="text" class="form-control "  name="year"
                                   placeholder="Year..." wire:model="year"  >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('year')
                            <div class="invalid-feedback">
                                Please type Year.
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-12">
                            <label  class="form-label mt-2">Plate:</label>
                            <input type="text" class="form-control "  name="plate"
                                   placeholder="Plate..." wire:model="plate"  >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('plate')
                            <div class="invalid-feedback">
                                Please type Plate.
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-12">
                            <label  class="form-label mt-2">Vin number:</label>
                            <input type="text" class="form-control "  name="vin"
                                   placeholder="Vin number..." wire:model="vin"  >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('vin')
                            <div class="invalid-feedback">
                                Please type Vin number.
                            </div>
                            @enderror

                        </div>

                        <div class="col-md-12">
                            <label  class="form-label mt-2">E-pass:</label>
                            <input type="text" class="form-control "  name="epass"
                                   placeholder="E-pass..." wire:model="epass"  >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('epass')
                            <div class="invalid-feedback">
                                Please type E-pass.
                            </div>
                            @enderror

                            </div>
                        <div class="col-md-12 mt-2">
                            <div class="mb-3 mt-2">

                                <label class="form-label">Tag Expires:</label>
                                <div class="input-group" id="end_time-input-group" wire:ignore>
                                    <x-flatpickr  class="flatpickr_date"  id="tag_expires" name="tag_expires" show-time :time24hr="false" alt-format="m/d/Y h:i K" wire:model="tag_expires"   value="{{$tag_expires}}"  />
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                                @error('tag_expires')
                                <div class="invalid-feedback show">
                                    Please select a valid datetime.
                                </div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="row">
                                <div  class="col-lg-12 ">
                                    <button class="btn btn-lg btn-success mt-2 float-end"   type="submit"   >SAVE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            @endif

        </div>
    </div>


</div>