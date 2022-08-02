<div>

        <h4 class="card-title mb-4">Referral Information
            @if($show)<button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="$emit('editReferralinfo')"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</button>@endif
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
                            <th scope="row">Referral :</th>
                            <td>{{$assignment->referral->full_name}}</td>
                        </tr>
                        @if($assignment->carrier)
                            <tr>
                                <th scope="row">Carrier :</th>
                                <td>{{$assignment->carrier->full_name}}</td>
                            </tr>
                        @endif
                        @if($assignment->carrier_info)
                                <tr>
                                    <th scope="row">Carrier  Info:</th>
                                    <td>{{$assignment->carrier_info}}</td>
                                </tr>
                            @endif

                        <tr>
                            <th scope="row">Claim Number:</th>
                            <td>{{$assignment->claim_number}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Job Type:</th>
                            <td>
                                <?php $count=0;?>
                                @foreach($assignment->job_types as $job_types)
                                    <?php $count++;?>
                                    @if($count == 1)
                                        {{$job_types->name}}
                                    @else
                                        {{" / $job_types->name"}}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Dol:</th>
                            <td><h5 class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i>{{$assignment->dol_date}}</h5></td>
                        </tr>
                        <tr>
                            <th scope="row">Created:</th>
                            <td><h5 class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i>{{$assignment->created_date}} - {{$assignment->user_created->name}}</h5></td>
                        </tr>
                        <tr>
                            <th scope="row">Last Update:</th>
                            <td><h5 class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i>{{$assignment->updated_date}} - {{$assignment->user_updated->name}}</h5></td>
                        </tr>
                        <tr>
                            <th scope="row">Adjuster Info:</th>
                            <td> <p class="text-left">{{$assignment->adjuster_info}}</p> </td>
                            <br>
                            <br>
                        </tr>
                        </tbody>
                    </table>
                </div>
           @else



                <form class="needs-validation  was-validated" action="" wire:submit.prevent.lazy="update(Object.fromEntries(new FormData($event.target)))"  novalidate>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="mb-3" wire:ignore>
                                        <label class="form-label">Referral</label>
                                        <select class="select2 form-control select2-multiple select_referral"
                                                name="referral_id" data-placeholder="Select ...">
                                            <option selected>chose...</option>
                                            @foreach($allReferrals as $ref)

                                                @if($ref)
                                                    <option {{$referralSelected == $ref->id ? ' selected': ' '}}  value="{{$ref->id}}">{{$ref->full_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('reportSelected')
                                    <div class="invalid-feedback show">
                                        Please select a report valid option.
                                    </div>
                                    @enderror
                                </div>

                                @if($showCarrierSelect)
                                    <div class="col-lg-12">
                                        <div class="mb-3" >
                                            <label class="form-label">Carrier</label>
                                            <select class=" form-control select2-multiple select_carrier"
                                                    name="carrier_id" data-placeholder="Select ...">
                                                <option selected>chose...</option>
                                                @foreach($carrierLists as $carr)

                                                    @if($carr)
                                                        <option {{$carrierSelected == $carr->id ? ' selected': ' '}}  value="{{$carr->id}}">{{$carr->full_name}}</option>

                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                @endif


                                @if($referral_type_id != 9)
                                    <div class="col-md-12">
                                        <label  class="form-label mt-2">Carrier Info:</label>
                                        <input type="text" class="form-control "  name="carrier_info"
                                               placeholder="Carrier info" wire:model="carrier_info"  >

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('street')
                                        <div class="invalid-feedback">
                                            Please type carrier info.
                                        </div>
                                        @enderror

                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <label  class="form-label mt-2">Claim Number:</label>
                                    <input type="text" class="form-control "  name="claim_number"
                                           placeholder="Claim Number..." wire:model="claim_number"  >

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('claim_number')
                                    <div class="invalid-feedback">
                                        Please type claim number.
                                    </div>
                                    @enderror

                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="mb-3 mt-2">

                                        <label class="form-label">Date of loss</label>
                                        <div class="input-group" id="end_time-input-group" wire:ignore>
                                            <x-flatpickr  class="flatpickr_date"  id="date_of_loss" name="date_of_loss" show-time :time24hr="false" alt-format="m/d/Y h:i K" wire:model="date_of_loss"   value="{{$date_of_loss}}"  />
                                            <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                        </div>
                                        @error('end_date')
                                        <div class="invalid-feedback show">
                                            Please select a valid datetime.
                                        </div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <label  class="form-label mt-2">Adjuster Info:</label>
{{--                                    <input type="text" class="form-control "  name="claim_number"--}}
{{--                                           placeholder="Claim Number..." wire:model="claim_number"  >--}}
                                    <textarea id="textarea" class="form-control" maxlength="225" rows="3" wire:model="adjuster_info"  name="adjuster_info"
                                              placeholder="Adjuster info limit of 225 chars."></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('street')
                                    <div class="invalid-feedback">
                                        Please type carrier info.
                                    </div>
                                    @enderror

                                </div>

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
    @push('js')
        <script>
            $(function (){
                $('.select2').select2();
                $('#date_of_loss').on('change.datetimepicker', function (e){
                    let data = $(this).val();
                    @this.set('date_dol', data);
                });

            });

            document.addEventListener('livewire:load', function (event) {
                @this.on('editReferralinfo', function () {

                    console.log('editReferralinfo');
                    setTimeout(function(){
                        $('.select2').select2();
                        $('.select_referral').on('change', function (e){
                            let data = $(this).val();
                            @this.set('referralSelected', data);
                        });

                    },500);

                });
                @this.on('contentChange', function () {

                    console.log('contentChange');
                    setTimeout(function(){
                        $('.select2').select2();
                        $('.select_referral').on('change', function (e){
                            let data = $(this).val();
                            @this.set('referralSelected', data);
                        });

                    },500);

                });
            });

        </script>
    @endpush


</div>



