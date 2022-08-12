<div>
    @if($checkInvoices==0)
        <div class="alert alert-danger" role="alert">
            No Invoices found, finish before add a payment!!!
        </div>
    @endif
    <h4 class="card-title mb-4">Payments <button type="button" class="btn btn-primary btn-sm float-end" wire:click="$emit('newPayment')"><i class="fas fa-plus"></i> <i class="fas fa-money-bill-wave"></i></button></h4>
    @if($showAdd)
        {{--  INSERT NEW PAYMENT      --}}
        <div class="card">
            <div class="card-body">
{{--                <form class="needs-validation  was-validated" action=""  novalidate>--}}
                    <form  class="needs-validation  was-validated" novalidate action=""  wire:submit.prevent="newPayment(Object.fromEntries(new FormData($event.target)))">

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="formrow-firstname-input" class="form-label">Payment Type</label>
                                    <select class="form-select" id="autoSizingSelect" name="payment_type" wire:model="payment_type" wire:change="invoiceList"  >
                                        <option selected>Select...</option>
                                        @if(count($invoicesOpen) > 0)
                                            <option value="partial_payment">Partial payment</option>
                                            <option value="total_payment">Total Payment</option>
                                        @else
                                            <option value="fee_payment">Fee Payment</option>
                                        @endif


                                    </select>
                                    @error('payment_type')
                                    <div class="invalid-feedback show">
                                        Please select one option...
                                    </div>
                                    @enderror
                                </div>
                            <div class="col-md-4">

{{--@dump(count($invoicesOpen))--}}
{{--@dump(count($invoicesFees))--}}
                                <label for="formrow-firstname-input" class="form-label">Invoice</label>
                                <select class="form-select" id="autoSizingSelect" name="billing_id" wire:model="billing_id" wire:change="balance"  placeholder="mm/dd/yyyy">
                                    <option selected>Select...</option>
                                    @if(count($invoicesOpen) > 0)

                                        @foreach($invoicesOpen as $invoice)
                                            <option value="{{$invoice->id}}">{{$invoice->invoice_id}}</option>
                                        @endforeach
                                    @else
                                        @foreach($invoicesFees as $invoice)
                                            <option value="{{$invoice->id}}">{{$invoice->invoice_id}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('billing_id')
                                <div class="invalid-feedback show">
                                    Please select one option...
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-4">
                                <div class="col-md-12 ">
                                    <label>Payment date</label>
                                    <div class="input-group" id="payment_date" wire:ignore>
                                        <x-flatpickr   id="payment_date" class="flatpickr_date" name="payment_date" wire:model="payment_date"   value="{{$payment_date}}" />
                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                    @error('payment_date')
                                    <div class="invalid-feedback show">
                                        Please type a valid date.
                                    </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                            <div class="row mt-2">

                                <div class="col-md-6">
                                    <label  class="form-label">Payment Amount</label>
                                    <input type="text" class="form-control"  name="payment_amount"
                                           placeholder="$0.00" wire:model.debounce.1000ms="payment_amount"  required>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('payment_amount')
                                    <div class="invalid-feedback">
                                        Please type a valid option.
                                    </div>
                                    @enderror

                                </div>

                        </div>
                            <div class="row mt-2">
                                <div class="col-md-8 mt-2">
                                    @if($showBalance)
                                    <table class="table align-middle table-nowrap">
                                        <tbody>
                                        <tr>
                                           <td class="text-end">Invoice Total:</td>
                                           <td><span class="">${{$invoice_total}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">Partial Payment Total:</td>
                                            <td><span class="">-${{$partial_payment_total}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">Payment:</td>
                                            <td><span class="">-${{$payment_amount}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end"><strong>Balance Total:</strong></td>
                                            <td>

                                                <span class="{{$balance_class}}"> ${{$balance_total}}</span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @endif

                                </div>
                                <div  class="col-lg-4 mt-2">

                                @switch($payment_type)
                                    @case('partial_payment')
                                                @if($balance_total > 0 && $payment_amount > 0)
                                                        <button class="btn btn-sm btn-lg btn-success mt-2 float-end"  type="submit"   >ADD PAYMENT</button>
                                                @else
                                                    @if($payment_amount == 0)
                                                <h6 class="text-danger float-end"> - Amount must be more them $0 </h6>
                                                        @endif
                                                        <h6 class="text-danger float-end"> - Balance cannot be less or equal them $0 </h6>
                                                @endif
                                    @break
                                    @case('total_payment')
                                        @if($balance_total == 0)
                                            <button class="btn btn-sm btn-lg btn-success mt-2 float-end"   type="submit"   >ADD PAYMENT</button>
                                        @else
                                            <h6 class="text-danger float-end">Balance must be equal to $0 </h6>
                                        @endif
                                    @break
                                    @case('fee_payment')
                                        <button class="btn btn-sm btn-lg btn-success mt-2 float-end"   type="submit"   >ADD PAYMENT</button>
                                        @break
                                    @default


                                @endswitch
                                    <button type="button" class="btn btn-sm btn-secondary  waves-effect waves-light  mt-2 me-2 float-end" wire:click.prevent="back"> <i class="fas fa-chevron-left font-size-16 align-middle "></i> Back</button>
                                </div>
{{--                                @else--}}
{{--                                    <div  class="col-lg-4 mt-2">--}}
{{--                                        <h6 class="text-danger float-end"> Invoice Amount cannot be less them $0 </h6>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                                --}}
{{--                                --}}

                            </div>



                    </div>
                </form>

            </div>
        </div>
    @else
        {{--  SHOW PAYMENTS      --}}
        <div class="card">
            <div class="card-body">


                <ul class="nav nav-pills bg-light rounded" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#payments-valid" role="tab">History</a>
                    </li>

                </ul>
                <div class="tab-content mt-4">
                    <div class="tab-pane active" id="payments-valid" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 330px;">
                            <table class="table align-middle table-nowrap">
                                <thead>
                                <tr>
                                    <td><h5 class="font-size-11 mb-1">Invoice</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Amount</h5></td>
                                    <td><h5 class="font-size-11 mb-1" >Date Payment</h5></td>
                                    <td><h5 class="font-size-11 mb-1"></h5>Edited</td>
                                    <td><h5 class="font-size-11 mb-1"></h5>-</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if($listPayments->isNotEmpty())
                                    @foreach($listPayments as $payment)
                                        <tr>
                                            <td style="width: 50px;">
                                                <span class="badge text-uppercase  {{$payment->payment_type}}"> {{$payment->payment_type}}</span>
                                                <p class="mb-0 font-size-11"> #{{$payment->invoice_id}} </p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 ">{{$payment->amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 text-danger">{{$payment->payment_date_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-10">{{$payment->updated_date_view}}</p>
                                                <p class="text-muted  font-size-10">{{$payment->edited->name}}</p>
                                            </td>
                                            <td>
                                                @if($payment->payment_type != 'refund_payment')
                                                    <button type="button" class="btn btn-sm btn-danger" wire:click="$emit('refundPayment', {{$payment->id}})"><i class="fas fa-backspace"></i> Refund </button>
                                                @endif

                                            </td>
                                        </tr>

                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">
                                            <h6 class="text-center text-muted">No payments found ...</h6>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
