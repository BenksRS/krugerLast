<div>

    @if($checkJobreport==0)
        <div class="alert alert-danger" role="alert">
            No Job report Found, create one before add an invoice!!!
        </div>
    @endif
        @if(!isset($assignment->scheduling))
            <div class="alert alert-danger" role="alert">
                No Scheduled Date Found, Scheduled one before add an invoice!!!
            </div>
     @endif
    <h4 class="card-title mb-4">Billed Invoices @if(!$showAdd && $checkJobreport > 0 && isset($assignment->scheduling))<button type="button" class="btn btn-primary btn-sm float-end" wire:click="$emit('addInvoice')"><i class="fas fa-plus"></i> <i class="fas fa-file-invoice"></i></button>@endif</h4>

    @if($showAdd)
        {{--  ADD INVOICES --}}
        <div class="card">
            <div class="card-body">
                {{--            <form class="needs-validation  was-validated" action=""  >--}}
                <form  class="needs-validation  was-validated" novalidate action=""  wire:submit.prevent="newInvoice(Object.fromEntries(new FormData($event.target)))">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label  class="form-label">Invoice Number#</label>
                                    <input type="number" class="form-control"  name="invoice_id"
                                           placeholder="# invoice number" wire:model="invoice_id"  required>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('invoice_id')
                                    <div class="invalid-feedback">
                                        Please type a valid option.
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    {{--                                <input type="hidden" id="billed_date_edit" name="billed_date_edit"  value="{{$billed_date}}">--}}
                                    <div class="col-md-12 mt-2">
                                        <label>Billed date</label>
                                        <div class="input-group" id="service_date" wire:ignore>
                                            <x-flatpickr   id="billed_date" class="flatpickr_date" name="billed_date" wire:model="billed_date"   value="{{$billed_date}}" />
                                            <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                        </div>
                                        @error('billed_date')
                                        <div class="invalid-feedback show">
                                            Please type a valid date.
                                        </div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label  class="form-label">Billed Amount</label>
                                    <input type="text" class="form-control"  name="billed_amount"
                                           placeholder="$0.00" wire:model.debounce.1000ms="billed_amount"  required>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('billed_amount')
                                    <div class="invalid-feedback">
                                        Please type a valid option.
                                    </div>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <label  class="form-label">Before Fees Amount</label>
                                    <input type="text" class="form-control"  name="fee_amount"
                                           placeholder="-$0.00" wire:model.debounce.1000ms="fee_amount"  required>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('fee_amount')
                                    <div class="invalid-feedback">
                                        Please type a valid option.
                                    </div>
                                    @enderror

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label  class="form-label">Discount Amount</label>
                                    <input type="text" class="form-control"  name="discount_amount"
                                           placeholder="-$0.00" wire:model.debounce.1000ms="discount_amount"  required>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('discount_amount')
                                    <div class="invalid-feedback">
                                        Please type a valid option.
                                    </div>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <label  class="form-label">Discount Settlement Amount</label>
                                    <input type="text" class="form-control"  name="settlement_amount"
                                           placeholder="-$0.00" wire:model.debounce.1000ms="settlement_amount"  required>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    @error('settlement_amount')
                                    <div class="invalid-feedback">
                                        Please type a valid option.
                                    </div>
                                    @enderror
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6 mt-2">
                                        <h5> Invoice Total: <span class="text-muted text-success">${{$invoice_total}}</span> </h5>
                                    </div>

                                    @if($invoice_total >= 0)
                                        <div  class="col-lg-6 ">
                                            <button class="btn btn-sm btn-lg btn-success mt-2 float-end"   type="submit"   >ADD</button>
                                        </div>
                                    @else
                                        <div  class="col-lg-6 mt-2">
                                            <h6 class="text-danger float-end"> Invoice Amount cannot be less them $0 </h6>
                                        </div>
                                    @endif
                                </div>

                            </div>


                        </div>


                    </div>
                </form>

            </div>
        </div>
    @else

        {{--    INVOICES actives  --}}
        <div class="card">
            <div class="card-body">


                <ul class="nav nav-pills bg-light rounded" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#invoices-valid" role="tab">Invoice</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#invoices-history" role="tab">History</a>
                    </li>

                </ul>
                <div class="tab-content mt-4">
                    <div class="tab-pane active" id="invoices-valid" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 330px;">
                            <table class="table align-middle table-nowrap">
                                <thead>
                                <tr>
                                    <td><h5 class="font-size-11 mb-1">Invoice</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Billed A.</h5></td>
                                    <td><h5 class="font-size-11 mb-1">B. Fees</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Discount</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Discount Settlement</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Invoce A.</h5></td>
                                    <td><h5 class="font-size-11 mb-1" >Date</h5></td>

                                    <td><h5 class="font-size-11 mb-1"></h5>-</td>
                                </tr>
                                </thead>

                                <tbody>
                                @if($listInvoices->where('type', 'active')->isNotEmpty())

                                    @foreach($listInvoices->where('type', 'active') as $invoice)
                                        <tr>
                                            <td style="width: 50px;">

                                                <span class="badge text-uppercase  {{$invoice->status}}">{{$invoice->status}}</span>
                                                <p class="mb-0 font-size-11"> #{{$invoice->invoice_id}} </p>



                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 ">{{$invoice->billed_amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 text-danger">{{$invoice->fee_amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 text-danger">{{$invoice->discount_amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 text-danger">{{$invoice->settlement_amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 text-success">{{$invoice->invoice_amount}}</p>
                                            </td>
                                            <td >
                                                <p class="text-muted mb-0 font-size-10">{{$invoice->billed_date_view}}</p>
                                                <p class="text-muted  font-size-10">{{$invoice->user->name}}</p>
                                            </td>
                                            <td>
                                                @if($invoice->status != 'paid')
                                                    <button type="button" class="btn btn-sm btn-primary" wire:click="$emit('editInvoice', {{$invoice->id}})"><i class="fa fa-edit"></i> </button>
                                                @endif
                                            </td>
                                        </tr>

                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">
                                            <h6 class="text-center text-muted">No invoices found ...</h6>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="invoices-history" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 330px;">
                            <table class="table align-middle table-nowrap">
                                <thead>
                                <tr>
                                    <td><h5 class="font-size-11 mb-1">Invoice</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Billed A.</h5></td>
                                    <td><h5 class="font-size-11 mb-1">B. Fees</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Discount</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Discount Settlement</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Invoce A.</h5></td>
                                    <td><h5 class="font-size-11 mb-1" >Date Billed</h5></td>
                                    <td><h5 class="font-size-11 mb-1">Edited</h5></td>
                                </tr>
                                </thead>
                                <tbody>
                                @if($listInvoices->where('type', 'disable')->isNotEmpty())
                                    <?php $invoice_atual=''; ?>
                                    @foreach($listInvoices->where('type', 'disable') as $invoice)
                                        <tr>
                                            <td style="width: 50px;">
                                                @if($invoice_atual != $invoice->invoice_id)
                                                    <p class="mb-0 font-size-11"> #{{$invoice->invoice_id}}</p>
                                                @endif
                                                <?php $invoice_atual=$invoice->invoice_id; ?>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 ">{{$invoice->billed_amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 ">{{$invoice->fee_amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 ">{{$invoice->discount_amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 ">{{$invoice->settlement_amount_view}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 ">{{$invoice->invoice_amount}}</p>
                                            </td>
                                            <td >
                                                <p class="text-muted mb-0 font-size-10">{{$invoice->billed_date_view}}</p>
                                                <p class="text-muted  font-size-10">{{$invoice->user->name}}</p>
                                            </td>
                                            <td>
                                                <p class="text-muted mb-0 font-size-11 ">{{$invoice->updated_at_view}}</p>
                                                <p class="text-muted  font-size-10">{{$invoice->edited->name}}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">
                                            <h6 class="text-center text-muted">No invoices found ...</h6>
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
</div>
@endif

<script>

    {{--function handleChange(selectedDates, dateStr, instance) {--}}

    {{--    let id_info = instance.element.id;--}}
    {{--    @this.set(id_info, dateStr);--}}

    {{--    // console.log({ selectedDates, dateStr, instance, test });--}}
    {{--}--}}

    {{--document.addEventListener('livewire:load', function (event) {--}}
    {{--    @this.on('addInvoice', function () {--}}
    {{--        setTimeout(function(){--}}
    {{--            $('#billed_date').flatpickr({"enableTime":true,"dateFormat":"Y-m-d H:i","altInput":true,"altFormat":"m\/d\/Y h:i K","time_24hr":false,"disable":[]});--}}
    {{--            $('#billed_date').on('change', function (){--}}
    {{--                let data= $(this).val();--}}
    {{--                @this.set('billed_date', data);--}}
    {{--            });--}}
    {{--        },700);--}}

    {{--    });--}}
    {{--    @this.on('editInvoice', function () {--}}
    {{--        setTimeout(function(){--}}
    {{--            let edit_date = $('#billed_date_edit').val();--}}

    {{--            $('#billed_date').flatpickr({"enableTime":true,"defaultDate": [edit_date],"dateFormat":"Y-m-d H:i","altInput":true,"altFormat":"m\/d\/Y h:i K","time_24hr":false,"disable":[]});--}}

    {{--            $('#billed_date').on('change', function (){--}}
    {{--                let data= $(this).val();--}}
    {{--                @this.set('billed_date', data);--}}
    {{--            });--}}
    {{--        },700);--}}

    {{--    });--}}
    {{--});--}}

</script>
