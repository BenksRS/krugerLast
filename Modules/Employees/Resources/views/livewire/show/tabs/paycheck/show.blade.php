<div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-16">Paycheck # {{$paycheck->id}}</h4>
                        <div class="mb-4">
                            <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-start" wire:click.prevent="showExtra"> <i class="bx bx-plus font-size-16 align-middle "></i><i class="bx bx-minus font-size-16 align-middle "></i> Extra</button>
                            <br>
                        </div>
                    </div>
                    <hr>

                    <div class="py-2 mt-3">


                    </div>
                    <div class="py-2 mt-3">
                        <h3 class="font-size-15 fw-bold">Week Summary</h3>
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="font-size-14 mb-1">{{$paycheck->timesheet->start_md}} <small class="text-muted">to</small> {{$paycheck->timesheet->end_md}}/{{$paycheck->timesheet->year}}</h5>
                                <p class="text-muted mb-0">Monday to Sunday </p>
                            </div>
                            <div class="col-md-2">

                                <h5 class="font-size-14 mb-0">{{$paycheck->timesheet->due_on_view}}</h5>
                                <p class="text-muted mb-0">Due on:</p>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-end">Sub Amount</th>
                                <th class="text-end">Total Amount</th>
                            </tr>
                            </thead>
                            <tbody class="font-size-10">

                           @if($paycheck->finance->week > 0)
                               <tr>
                                   <td>WEEK</td>
                                   <td class="text-end"></td>
                                   <td class="text-end">${{$this->showMoney($paycheck->finance->week)}}</td>
                               </tr>
                               {{--// REGULAR WEEK--}}
                               @switch($paycheck->timesheet->rates->type)
                                   @case('D')
                                   @if($paycheck->timesheet->finance->regular->days > 0)
                                       <tr>
                                           <td>-- {{$paycheck->timesheet->finance->regular->days}} Regular Day's</td>
                                           <td class="text-end">${{$this->showMoney($paycheck->timesheet->finance->regular->total)}}</td>
                                           <td class="text-end"></td>
                                       </tr>
                                   @endif
                                   @if($paycheck->timesheet->finance->weekend->days > 0)
                                       <tr>
                                           <td>-- {{$paycheck->timesheet->finance->weekend->days}} Weekend Day's</td>
                                           <td class="text-end">${{$this->showMoney($paycheck->timesheet->finance->weekend->total)}}</td>
                                           <td class="text-end"></td>
                                       </tr>
                                   @endif
                                   @if($paycheck->timesheet->finance->out->days > 0)
                                       <tr>
                                           <td>-- {{$paycheck->timesheet->finance->out->days}} Sleep out Day's</td>
                                           <td class="text-end">${{$this->showMoney($paycheck->timesheet->finance->out->total)}}</td>
                                           <td class="text-end"></td>
                                       </tr>
                                   @endif
                                   @if($paycheck->timesheet->finance->oncall->days > 0)
                                       <tr>
                                           <td>-- {{$paycheck->timesheet->finance->oncall->days}} On call Day's</td>
                                           <td class="text-end">${{$this->showMoney($paycheck->timesheet->finance->oncall->total)}}</td>
                                           <td class="text-end"></td>
                                       </tr>
                                   @endif
                                   @if($paycheck->timesheet->finance->hurricane->days > 0)
                                       <tr>
                                           <td>-- {{$paycheck->timesheet->finance->hurricane->days}} Hurricane Extra Day's</td>
                                           <td class="text-end">${{$this->showMoney($paycheck->timesheet->finance->hurricane->total)}}</td>
                                           <td class="text-end"></td>
                                       </tr>
                                   @endif
                                   @break
                               @endswitch


                           @endif

{{--// Receipts--}}
@if($paycheck->finance->receipts > 0)
    <tr>
        <td>RECEIPTS</td>
        <td class="text-end"></td>
        <td class="text-end">${{$this->showMoney($paycheck->finance->receipts)}}</td>
    </tr>



                            @if(count($paycheck->receipts) > 0)
                                @foreach($paycheck->receipts as $receipt)
                                    <tr>
                                        <td>-- {{$receipt->category}}  </td>
                                        <td class="text-end">${{$this->showMoney($receipt->amount)}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endif

@endif



{{--// Comissions--}}
@if($paycheck->finance->commission > 0)
    <tr>
        <td>COMMISSION</td>
        <td class="text-end"></td>
        <td class="text-end">${{$this->showMoney($paycheck->finance->commission)}}</td>
    </tr>

@if(count($paycheck->commissions) > 0)
    @foreach($paycheck->commissions as $commission)

        <tr>
            <td>-- #{{$commission->assignment_id}} -
                @if($commission->assignment->scheduling)
                    <i class="bx bx-calendar-event"></i>
                    {{$commission->assignment->scheduling->schedule_date}} <i class="bx bx-time-five"></i> {{$commission->assignment->scheduling->start_hour}} to {{$commission->assignment->scheduling->end_hour}} <i class="bx bx-user"></i> {{$commission->assignment->scheduling->tech->name}}
                @else
                    Not Scheduled!
                @endif


               / {{$commission->rule->name}} </td>
            <td class="text-end">${{$this->showMoney($commission->amount)}}</td>
            <td></td>
        </tr>
    @endforeach
@endif

@endif

                            <tr>
                                <td></td>
                                <td  class="border-0 text-end">
                                    <strong>Total</strong></td>
                                <td class="border-0 text-end"><h4 class="m-0">${{$this->showMoney($paycheck->finance->total)}}</h4></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
