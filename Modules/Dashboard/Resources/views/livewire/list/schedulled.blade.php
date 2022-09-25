<div>
    <style>
        nav svg{
            max-height: 20px;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="btn-group">
                                <button type="button" wire:click.prevent="export" class="btn btn-light dropdown-toggle" >
                                    <i class="fas fa-file-csv me-2"> </i> Export List and change to Message Sent
                                </button>
                            </div>


                        </div>
                        <div class="col-lg-4 float-end " >

                                <div class="d-flex flex-wrap text-center text-sm-start align-items-center p-4">
                                    <div class="d-sm-flex flex-wrap gap-2">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-primary btn-rounded" wire:click.prevent="changeDate('prev')">
                                                <i class="calendar-icon ic-arrow-line-left mdi mdi-chevron-left" data-action="move-prev"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-rounded" wire:click.prevent="changeDate('next')">
                                                <i class="calendar-icon ic-arrow-line-right mdi mdi-chevron-right" data-action="move-next"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <h5 class="m-0 ms-3 fw-bold">{{$dateDisplay}}
                                        <span class="ms-1 text-secondary opacity-50 fw-normal">{{$weekDisplay}}</span>
                                    </h5>
                                </div>
                            </div>

                    </div>
                    <div class="table-responsive mb-0" data-pattern="priority-columns">

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 listtable">
                            <thead>
                            <tr>

                                @if(in_array('Name', $selectedColumns))
                                    <th>ID</th>
                                @endif

                                @if(in_array('Job Type', $selectedColumns))
                                    <th>FISRT NAME</th>
                                @endif
                                @if(in_array('Schedule', $selectedColumns))
                                    <th>LAST NAME</th>
                                @endif
                                @if(in_array('Status', $selectedColumns))
                                    <th>PHONE</th>
                                @endif
                                @if(in_array('Referral', $selectedColumns))
                                    <th>CARRIER</th>
                                @endif
                                @if(in_array('Referral', $selectedColumns))
                                    <th>CLAIM NUMBER</th>
                                @endif
                                @if(in_array('Address', $selectedColumns))
                                    <th>ADDRESS</th>
                                @endif

                            </tr>

                            </thead>

                            <tbody >
                            <tr wire:loading>
                                <td colspan="100">
                                    <div style="margin-left: 48%">
                                        <div class="spinner-border text-primary col-lg-2 m-auto" >
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @foreach($list as $row)

                                @if(!$row->tags->contains(10))
                                <tr>

                                    @if(in_array('Street', $selectedColumns))
                                        <td><p><a href="{{url('assignments/show/'.$row->id)}}">{{$row->id}}</a></p></td>
                                    @endif
                                    @if(in_array('Street', $selectedColumns))
                                        <td><p>{{$row->first_name}}</p></td>
                                    @endif
                                    @if(in_array('Street', $selectedColumns))
                                        <td><p>{{$row->last_name}}</p></td>
                                    @endif

                                    @if(in_array('Street', $selectedColumns))
                                        <td>
                                            <?php $count=0; ?>
                                            @foreach($row->phones as $phone)
                                                @if($count==0)
                                                    <small>{{$phone->phone}}</small>
                                                @endif
                                                <?php $count++; ?>
                                            @endforeach
                                        </td>
                                    @endif
                                    @if(in_array('Street', $selectedColumns))
                                        <?php
                                        $check_carrier=array(582,583);

                                        if(isset($row->carrier_id)){
                                            if(!in_array($row->carrier_id, $check_carrier)){
                                                $carrier=\Modules\Referrals\Entities\Referral::find($row->carrier_id);
                                                $carrier_name=$carrier->company_entity;
                                            }else{
                                                $carrier_name='';
                                            }
                                        }else{
                                            if($row->carrier_info){
                                                $carrier_name=$row->carrier_info;
                                            }else{
                                                $carrier_name='';
                                            }

                                        }
                                        ?>
                                        <td><p>{{$carrier_name}}</p></td>
                                    @endif
                                    @if(in_array('Street', $selectedColumns))
                                        <td><p>{{$row->claim_number}}</p></td>
                                    @endif
                                    @if(in_array('Street', $selectedColumns))
                                        <td><p>{{$row->address->message}}</p></td>
                                    @endif






                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="float-start">
                        Total jobs: {{$list->count()}}
                    </div>
                    <div class="float-end">

                        {{--                        {{$list->links()}}--}}


                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
