
<div>
    <h4 class="card-title mb-4">Fiance Info</h4>
    <div class="row">
{{--        invoices --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title rounded-circle bg-warning bg-soft text-warning font-size-18"><i class="bx bx-note"></i></span>
                        </div>
                        <h5 class="font-size-14 mb-0">Invoices Total</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-muted mt-3">

                                <p>Total Amount</p>
                                <h4>${{$total_invoices_amount}}</h4>
                            </div>
                        </div>

                        {{--                            <div class="col-lg-6 align-self-end">--}}
                        {{--                                <div class="text-muted mt-3">--}}

                        {{--                                    <p>Amount Pending</p>--}}
                        {{--                                    <h4>$1,000.00</h4>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                    </div>
                </div>
            </div>
        </div>
{{--     payments    --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title rounded-circle bg-warning bg-soft text-warning font-size-18"><i class="bx bx-money"></i></span>
                        </div>
                        <h5 class="font-size-14 mb-0">Payments Total</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="text-muted mt-3">

                                <p>Total Paid</p>
                                <h4>${{$total_payments_amount}}</h4>
                            </div>
                        </div>

                                                    <div class="col-lg-6 text-end">
                                                        <div class="text-muted mt-3">

                                                            <p>After fees paid</p>
                                                            <h5>${{$total_fees_after}}</h5>
                                                        </div>
                                                    </div>
                    </div>
                </div>
            </div>
        </div>
        {{--     Balance open    --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title rounded-circle bg-warning bg-soft text-warning font-size-18"><i class="bx bx-stats"></i></span>
                        </div>
                        <h5 class="font-size-14 mb-0">Balance</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-muted mt-3">

                                <p>Pending amount</p>
                                <h4 class="{{($total_balance > 0) ? 'text-danger': ''}}    ">${{$total_balance}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
