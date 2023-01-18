<div>

    <h4 class="card-title mb-4">Loan Information
        @if($show)<button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="$emit('editLoan')"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</button>@endif
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
                            <th scope="row">Loan number :</th>
                            <td>{{$car->loan_number}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Loan monthly payment</th>
                            <td>{{$car->loan_times}}x ${{$car->loan_monthly_amount}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Down payment:</th>
                            <td>${{$car->down_payment}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Full Amount:</th>
                            <td>${{$full_amount}}</td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            @else
                {{--     EDIT    --}}

                <form class="needs-validation  was-validated" action="" wire:submit.prevent.lazy="update(Object.fromEntries(new FormData($event.target)))"  novalidate>
                    <div class="row">

                        <div class="col-md-12">
                            <label  class="form-label mt-2">Loan number:</label>
                            <input type="text" class="form-control "  name="loan_number"
                                   placeholder="Loan number..." wire:model="loan_number" >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('loan_number')
                            <div class="invalid-feedback">
                                Please type Loan number.
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-12">
                            <label  class="form-label mt-2">Down payment:</label>
                            <input type="text" class="form-control "  name="down_payment"
                                   placeholder="Down payment..." wire:model="down_payment" >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('loan_number')
                            <div class="invalid-feedback">
                                Please type Down payment.
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-12">
                            <label  class="form-label mt-2">Loan monthly times:</label>
                            <input type="text" class="form-control "  name="loan_times"
                                   placeholder="Loan monthly times..." wire:model="loan_times"  >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('loan_times')
                            <div class="invalid-feedback">
                                Please type Loan monthly times.
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-12">
                            <label  class="form-label mt-2">Loan monthly payment:</label>
                            <input type="text" class="form-control "  name="loan_monthly_amount"
                                   placeholder="Loan monthly payment..." wire:model="loan_monthly_amount"  >

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            @error('loan_monthly_amount')
                            <div class="invalid-feedback">
                                Please type Loan monthly payment.

                            </div>
                            @enderror

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
