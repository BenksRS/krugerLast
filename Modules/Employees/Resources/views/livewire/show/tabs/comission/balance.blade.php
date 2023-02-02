<div>

    <div class="row">
        {{--        invoices --}}

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title rounded-circle bg-warning bg-soft text-warning font-size-18"><i class="bx bx-note"></i></span>
                        </div>
                        <h5 class="font-size-14 mb-0">{{$dueMonthShow}}/{{$dueYearSelected}}</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-muted mt-3">

                                <p>Comissions Paid in {{$dueMonthNext}}/{{$dueYearNext}}</p>
                                <h4>${{$this->showMoney($current)}}</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{--     payments    --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title rounded-circle bg-warning bg-soft text-warning font-size-18"><i class="bx bx-money"></i></span>
                        </div>
                        <h5 class="font-size-14 mb-0">Balance Available Total</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="text-muted mt-3">

                                <p>Before {{$MonthActual}}</p>
                                <h4>${{$this->showMoney($balanceMonthBefore)}}</h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-muted mt-3">

                                <p>{{$MonthActual}}  Available</p>
                                <h4>${{$this->showMoney($balanceMonthActual)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--     Balance open    --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title rounded-circle bg-warning bg-soft text-warning font-size-18"><i class="bx bx-stats"></i></span>
                        </div>
                        <h5 class="font-size-14 mb-0">Pending Amount</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-muted mt-3">

                                <p>Pending amount (Waiting Payment) </p>
                                <h4>${{$this->showMoney($pending)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>