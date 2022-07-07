<div>
    <div class="row">
        <div class="col-lg-7">
            @livewire('assignments::show.tabs.finance.balance', ['assignment' => $assignment->id], key('assignment_show_finance_balance'))
        </div>
        <div class="col-lg-5">
            @livewire('assignments::show.tabs.finance.collection', ['assignment' => $assignment->id], key('assignment_show_finance_collection'))
        </div>
    </div>
    <div class="row">
            <div class="col-lg-4">
                @livewire('assignments::show.tabs.finance.notes', ['assignment' => $assignment->id], key('assignment_show_finance_notes'))
            </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    @livewire('assignments::show.tabs.finance.billing', ['assignment' => $assignment->id], key('assignment_show_finance_billing'))
                </div>
                <div class="col-lg-12">
                    @livewire('assignments::show.tabs.finance.payment', ['assignment' => $assignment->id], key('assignment_show_finance_payment'))
                </div>
            </div>
        </div>
{{--        <div class="col-lg-6">--}}
{{--            @livewire('assignments::show.tabs.finance.collection', ['assignment' => $assignment->id], key('assignment_show_finance_collection'))--}}
{{--        </div>--}}
    </div>


</div>
