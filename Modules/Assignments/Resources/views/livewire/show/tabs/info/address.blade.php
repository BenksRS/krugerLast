<div>
    <div>
        @if($show)
            <h4 class="card-title mb-4">Contact Information <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="edit"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</button></h4>

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


                    <div class="table-responsive">

                        <table class="table table-nowrap mb-0">
                            <tbody>
                            <tr>
                                <th scope="row">ADDRESS :</th>
                                <td class="font-size-11"><a href="{{$address_link}}" target="{{$address_target}}" > {{$address_message}} </a> </td>
                            </tr>
                            <tr>
                                <th scope="row">E-mail :</th>
                                <td>
                                    <a href="javascript: void(0);" id="inline-username" data-type="text" data-pk="1" data-title="Enter username">{{!empty($email) ? $email : 'NO E-MAIL ADDRESS FOUND ...'}}</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <h4 class="card-title mb-4">Contact Information </h4>
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation  was-validated" action="" wire:submit.prevent.lazy="update(Object.fromEntries(new FormData($event.target)))"  novalidate>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="col-md-12">
                                        <label  class="form-label">Street</label>
                                        <input type="text" class="form-control "  name="street"
                                               placeholder="Street" wire:model="street"  required>

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        @error('street')
                                        <div class="invalid-feedback">
                                            Please type a valid option.
                                        </div>
                                        @enderror

                                    </div>
                                    <div class="col-md-12">

                                        <label  class="form-label">City</label>
                                        <input type="text" class="form-control" name="city"
                                               placeholder="City" wire:model="city" required>
                                        @error('city')
                                        <div class="invalid-feedback">
                                            Please select a valid option.
                                        </div>
                                        @enderror
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <label  class="form-label">State (e.g."FL")</label>
                                        <input type="text" maxlength="2" class="form-control" name="state"
                                               placeholder="State"  wire:model="state" required>
                                        @error('state')
                                        <div class="invalid-feedback">
                                            Please input a valid state.
                                        </div>
                                        @enderror
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <label  class="form-label">Zipcode</label>
                                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="5" class="form-control" name="zipcode"
                                               placeholder="Zipcode"  wire:model="zipcode" required>
                                        @error('zipcode')
                                        <div class="invalid-feedback">
                                            Please input a valid zipcode.
                                        </div>
                                        @enderror
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <label  class="form-label">E-mail</label>
                                        <input type="email"  class="form-control" name="email"
                                               placeholder="add e-mail here ..."  wire:model="email">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            Please input a valid E-mail address.s
                                        </div>
                                        @enderror
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>

                                    </div>

                                    <div  class="col-lg-12 ">
                                        <button class="btn btn-sm btn-lg btn-success mt-2 float-end"   type="submit"   >SAVE</button>
                                    </div>
                                </div>


                            </div>


                        </div>
                    </form>

                </div>
            </div>
        @endif



    </div>

</div>
