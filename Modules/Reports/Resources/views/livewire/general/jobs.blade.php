<div>
    @php
        $sh = function ($field, $label, $class = '') use ($sortField, $sortDir) {
            $arrow = $sortField === $field ? ($sortDir === 'asc' ? ' ▲' : ' ▼') : '';
            return '<th class="sortable ' . $class . '" wire:click="sortBy(\'' . $field . '\')">' . e($label) . $arrow . '</th>';
        };
        $bh = function ($field, $label, $class = '') use ($bdSortField, $bdSortDir) {
            $arrow = $bdSortField === $field ? ($bdSortDir === 'asc' ? ' ▲' : ' ▼') : '';
            return '<th class="sortable ' . $class . '" wire:click="sortBreakdownBy(\'' . $field . '\')">' . e($label) . $arrow . '</th>';
        };
    @endphp
    <style>
        .table th { vertical-align: middle; }
        .table td { vertical-align: middle; }
        th.sortable { cursor: pointer; white-space: nowrap; user-select: none; }

        /* Header fixo ao rolar a tabela de jobs */
        .jobs-table-wrapper { max-height: 70vh; overflow: auto; }
        .jobs-table-wrapper thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #fff;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center flex-nowrap text-nowrap">
                        <div class="col">
                            <p class="text-muted mb-1">Total Jobs</p>
                            <h4>{{ $totals['jobs'] }}</h4>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Total Billed</p>
                            <h4>${{ number_format($totals['billed'], 2, '.', ',') }}</h4>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Total Tree</p>
                            <h4>${{ number_format($totals['tree'], 2, '.', ',') }}</h4>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Total 3d Party</p>
                            <h4>${{ number_format($totals['third_party'], 2, '.', ',') }}</h4>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Total Tree - 3d Party</p>
                            <h4>${{ number_format($totals['tree_net'], 2, '.', ',') }}</h4>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Total Tarp</p>
                            <h4>${{ number_format($totals['tarp'], 2, '.', ',') }}</h4>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Total Paid</p>
                            <h4>${{ number_format($totals['paid'], 2, '.', ',') }}</h4>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Total Balance</p>
                            <h4>${{ number_format($totals['balance'], 2, '.', ',') }}</h4>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Total Crane</p>
                            <h4>${{ number_format($totals['crane'], 2, '.', ',') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive jobs-table-wrapper mb-0">
                        <table class="table table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                {!! $sh('name', 'Name') !!}
                                {!! $sh('job_type', 'Job Type') !!}
                                {!! $sh('schedule', 'Schedule') !!}
                                {!! $sh('status', 'Status') !!}
                                {!! $sh('referral', 'Referral') !!}
                                {!! $sh('workers', 'Workers') !!}
                                {!! $sh('billed', 'Billed', 'text-end') !!}
                                {!! $sh('tree', 'Tree', 'text-end') !!}
                                {!! $sh('third_party', '3d Party', 'text-end') !!}
                                {!! $sh('tree_net', 'Tree - 3d Party', 'text-end') !!}
                                {!! $sh('tarp', 'Tarp', 'text-end') !!}
                                {!! $sh('paid', 'Paid', 'text-end') !!}
                                {!! $sh('balance', 'Balance', 'text-end') !!}
                                {!! $sh('crane', 'Crane', 'text-end') !!}
                                {!! $sh('discount', 'Discounts', 'text-end') !!}
                                {!! $sh('billed_date', 'Billed Date') !!}
                                {!! $sh('paid_date', 'Paid Date') !!}
                            </tr>
                            </thead>
                            <tbody>
                            <tr wire:loading>
                                <td colspan="100">
                                    <div class="spinner-border text-primary m-auto d-block"></div>
                                </td>
                            </tr>
                            @foreach($listAll as $row)
                                @php
                                    $billed      = (float) optional(optional($row->finance)->invoices)->total;
                                    $invoicesObj = optional(optional($row->finance)->invoices);
                                    $tree        = (float) ($invoicesObj->tree_amount_total ?? $invoicesObj->tree_amount);
                                    $thirdParty  = (float) $invoicesObj->third_party;
                                    $treeNet     = $tree - $thirdParty;
                                    $paid   = (float) optional(optional($row->finance)->payments)->total;
                                    $balance = (float) optional(optional($row->finance)->balance)->total;
                                    $crane  = (float) optional(optional($row->finance)->invoices)->crane_amount;
                                    $discount = (float) $invoicesObj->discount;
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ url('assignments/show/' . $row->id) }}">
                                            {{ $row->last_name }}, {{ $row->first_name }} #{{ $row->id }}
                                        </a>
                                    </td>
                                    <td>
                                        @foreach($row->job_types as $job)
                                            <span class="badge bg-light text-dark">{{ $job->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($row->scheduling)
                                            <i class="bx bx-calendar-event"></i> {{ $row->scheduling->schedule_date }}
                                        @else
                                            <span class="text-muted">Not Scheduled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->status)
                                            <span class="badge {{ strtolower($row->status->name) }}">{{ $row->status->name }}</span>
                                        @endif
                                    </td>
                                    <td>{{ strtolower($row->referral_carrier_full) }}</td>
                                    <td>
                                        @foreach($row->workers as $w)
                                            <span class="badge bg-soft-primary text-primary">
                                                {{ $workerMap[$w->worker_id] ?? ('#' . $w->worker_id) }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="text-end">${{ number_format($billed, 2, '.', ',') }}</td>
                                    <td class="text-end">${{ number_format($tree, 2, '.', ',') }}</td>
                                    <td class="text-end">${{ number_format($thirdParty, 2, '.', ',') }}</td>
                                    <td class="text-end">${{ number_format($treeNet, 2, '.', ',') }}</td>
                                    <td class="text-end">${{ number_format($billed - $tree, 2, '.', ',') }}</td>
                                    <td class="text-end">${{ number_format($paid, 2, '.', ',') }}</td>
                                    <td class="text-end">${{ number_format($balance, 2, '.', ',') }}</td>
                                    <td class="text-end">${{ number_format($crane, 2, '.', ',') }}</td>
                                    <td class="text-end">${{ number_format($discount, 2, '.', ',') }}</td>
                                    <td>{{ optional(optional($row->finance)->collection)->billed_date_view ?? '-' }}</td>
                                    <td>{{ optional(optional($row->finance)->collection)->payment_date_view ?? '-' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="float-start">Total jobs: {{ $listAll->total() }}</div>
                    <div class="float-end">{{ $listAll->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($breakdown->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">By Worker <small class="text-muted">(full job value counted for each worker)</small></h5>
                        <div class="table-responsive mb-0">
                            <table class="table table-bordered mb-0">
                                <thead>
                                <tr>
                                    {!! $bh('name', 'Worker') !!}
                                    {!! $bh('jobs', 'Jobs', 'text-end') !!}
                                    {!! $bh('billed', 'Billed', 'text-end') !!}
                                    {!! $bh('tree', 'Tree', 'text-end') !!}
                                    {!! $bh('third_party', '3d Party', 'text-end') !!}
                                    {!! $bh('tree_net', 'Tree - 3d Party', 'text-end') !!}
                                    {!! $bh('tarp', 'Tarp', 'text-end') !!}
                                    {!! $bh('paid', 'Paid', 'text-end') !!}
                                    {!! $bh('balance', 'Balance', 'text-end') !!}
                                    {!! $bh('crane', 'Crane', 'text-end') !!}
                                    {!! $bh('discount', 'Discounts', 'text-end') !!}
                                    {!! $bh('tree_net', 'Tree Removal 2%', 'text-end') !!}
                                    {!! $bh('tarp', 'Roof Tarp 1%', 'text-end') !!}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($breakdown as $wk)
                                    <tr>
                                        <td>{{ $wk['name'] }}</td>
                                        <td class="text-end">{{ $wk['jobs'] }}</td>
                                        <td class="text-end">${{ number_format($wk['billed'], 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['tree'], 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['third_party'], 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['tree_net'], 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['tarp'], 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['paid'], 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['balance'], 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['crane'], 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['discount'], 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['tree_net'] * 0.02, 2, '.', ',') }}</td>
                                        <td class="text-end">${{ number_format($wk['tarp'] * 0.01, 2, '.', ',') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
