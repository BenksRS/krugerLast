<div>

    <h4 class="card-title mb-4">Insurance Information
        @if($show)<button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="$emit('editInsurance')"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</button>@endif
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
                            <th scope="row">Insurance policy:</th>
                            <td>{{$car->insurance_policy}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Insurance Amount Monthly:</th>
                            <td>${{$car->insurance_amount_monthly}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Insurance Expires:</th>
                            <td>{{$car->insurance_expires}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            @else
                {{--     EDIT    --}}

                <form class="needs-validation  was-validated" action="" wire:submit.prevent.lazy="update(Object.fromEntries(new FormData($event.target)))"  novalidate>
                    <div class="row">

                        <div class="col-md-12">
                            <label  class="form-label mt-2">Insurance policy:</label>
                            <input type="text" class="form-control "  name="insurance_policy"
                                   placeholder="Insurance policy..." wire:model="insurance_policy" >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('insurance_policy')
                            <div class="invalid-feedback">
                                Please type Insurance policy.
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-12">
                            <label  class="form-label mt-2">Insurance Amount Monthly:</label>
                            <input type="text" class="form-control "  name="insurance_amount_monthly"
                                   placeholder="Insurance Amount Monthly..." wire:model="insurance_amount_monthly"  >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('insurance_amount_monthly')
                            <div class="invalid-feedback">
                                Please type Insurance Amount Monthly.
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="mb-3 mt-2">

                                <label class="form-label">Insurance Expires:</label>
                                <div class="input-group" id="end_time-input-group" wire:ignore>
                                    <x-flatpickr  class="flatpickr_date"  id="insurance_expires" name="insurance_expires" show-time :time24hr="false" alt-format="m/d/Y h:i K" wire:model="insurance_expires"   value="{{$insurance_expires}}"  />
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                                @error('insurance_expires')
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