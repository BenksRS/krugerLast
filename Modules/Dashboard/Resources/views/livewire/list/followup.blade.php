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
                    TOTAL COLLECTION :: ${{$total_collection}}<br>
                    <div class="row mb-3">
                        <div class="col-lg-8">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Selected Rows <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-md">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <label> <input type="radio" wire:model="selectedRows" value="10">10</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label> <input type="radio" wire:model="selectedRows" value="50">50</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label> <input type="radio" wire:model="selectedRows" value="100">100</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label> <input type="radio" wire:model="selectedRows" value="999999">ALL</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Selected Columns <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-md">
                                    <ul class="list-group">
                                        @foreach($columns as $column)
                                            <li class="list-group-item">
                                                <label> <input type="checkbox" wire:model="selectedColumns" value="{{$column}}">
                                                    {{$column}}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort BY<i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-md">
                                    <ul class="list-group">
                                        @foreach($sortByColumns as $column => $label)
                                            <li class="list-group-item">
                                                <label><input type="radio" wire:model="sortBy" value="{{$column}}">{{$label}}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Status <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-md">
                                    <ul class="list-group">
                                        @foreach($statusCollection as $sc)
                                            <li class="list-group-item">
                                                <label> <input type="radio" wire:model="selectedStatus" value="{{$sc->id}}">
                                                    {{$sc->name}}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 float-end " >
                            <input type="text" class="form-control" placeholder="Search..." wire:model="searchAssignment">
                        </div>
                    </div>
    
                    <!-- Filter Collection -->
                    <div class="row mb-3">
        
                        <div class="col-lg-6">
                            <div class="mb-3" wire:ignore>
                                <label class="form-label">Referral</label>
                                <a href="#" wire:click.prevent="clearFilter('referral_id')" onClick="clearReferral()" class="float-end">clear</a>
                                <select class="select2 form-control select2-multiple select_referral select-filter"
                                        name="referral_id"
                                        data-model="referral_id"
                                        wire:model="filters.referral_id">
                                    <option selected value>chose...</option>
                                    @foreach($allReferrals as $ref)
                                        <option value="{{$ref->id}}">{{$ref->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3" wire:ignore>
                                <label class="form-label">Carrier</label>
                                <a href="#" wire:click="clearFilter('carrier_id')" onClick="clearCarrier()" class="float-end">clear</a>
                                <select class="select2 form-control select2-multiple select_carrier select-filter"
                                        name="carrier_id"
                                        data-model="carrier_id"
                                        wire:model="filters.carrier_id">
                                    <option selected value>chose...</option>
                                    @foreach($allCarriers as $carrier)
                                        <option value="{{$carrier->id}}">{{$carrier->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                    </div>
                    <!-- End Filter Collection -->
                    
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 listtable">
                        <thead>
                        <tr>
                            @if(in_array('Billed Date', $selectedColumns))
                                <th>Billed Date</th>
                            @endif
                                @if(in_array('Status Collection', $selectedColumns))
                                    <th>Status Collection</th>
                                @endif

                            @if(in_array('Name', $selectedColumns))
                                <th>Name</th>
                            @endif
                            @if(in_array('Job Type', $selectedColumns))
                                <th>Job Type</th>
                            @endif
                            @if(in_array('Invoices', $selectedColumns))
                                <th>Invoices</th>
                            @endif
                                @if(in_array('Referral', $selectedColumns))
                                    <th>Referral</th>
                                @endif
                            @if(in_array('Status', $selectedColumns))
                                <th>Status</th>
                            @endif
                                @if(in_array('projected_lien', $selectedColumns))

                                    <td><p>{{$row->projected_lien_date_view}}</p>
                                    </td>
                                @endif
                                @if(in_array('follow_up', $selectedColumns))
                                    <th>Follow up</th>
                                @endif
                            @if(in_array('days_from_billing', $selectedColumns))
                                <th>Days from billing</th>
                            @endif
                            @if(in_array('days_from_service', $selectedColumns))
                                <th>Days from Service</th>
                            @endif

                            @if(in_array('Address', $selectedColumns))
                                <th>Address</th>
                            @endif
                            @if(in_array('Street', $selectedColumns))
                                <th>Street</th>
                            @endif
                            @if(in_array('City', $selectedColumns))
                                <th>City</th>
                            @endif
                            @if(in_array('State', $selectedColumns))
                                <th>State</th>
                            @endif
                            @if(in_array('Phone', $selectedColumns))
                                <th>Phone</th>
                            @endif
                            @if(in_array('Created by', $selectedColumns))
                                <th>Created by</th>
                            @endif
                            @if(in_array('Created At', $selectedColumns))
                                <th>Created At</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody wire:loading.remove>
                        @foreach($list as $row)


                            <tr>
                                @if(in_array('Billed Date', $selectedColumns))
                                    <td><p class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i>{{$row->finance->collection->billed_date_view}}</p></td>
                                @endif
                                    @if(in_array('Status Collection', $selectedColumns))
                                        <td><span class="badge {{strtolower($row->status_collection->name)}}">{{$row->status_collection->name}}</span></td>
                                    @endif
                                @if(in_array('Name', $selectedColumns))
                                        <td><a href="{{url('assignments/show/'.$row->id)}}">{{$row->last_name}}, {{$row->first_name}} #{{$row->id}}

                                                @if($row->event)
                                                    <span class="badge alert-danger" >{{$row->event->name}}</span>
                                                @endif
                                                @if($row->tags)
                                                    @foreach($row->tags as $tag)
                                                        <span class="badge tagable float-start ">{{$tag->name}}</span>
                                                        {{--                                                <span class="badge alert-info">{{$tag->name}}</span>--}}
                                                    @endforeach
                                                @endif
                                            </a>


                                        </td>
                                @endif
                                @if(in_array('Job Type', $selectedColumns))
                                    <td><p>
                                            <?php $count=0;?>
                                            @foreach($row->job_types as $job)
                                                <?php $count++;?>
                                                @if($count == 1)
                                                    {{$job->name}}
                                                @else
                                                    {{" / $job->name"}}
                                                @endif
                                            @endforeach
                                        </p></td>
                                @endif

                                @if(in_array('Invoices', $selectedColumns))
                                    <td>
                                        <p>
                                            @foreach($row->invoices as $invoice)
                                                {{$invoice->invoice_id}}<br>
                                            @endforeach
                                        </p>
                                    </td>
                                @endif
                                    @if(in_array('Referral', $selectedColumns))
                                        <td><p>{{strtolower($row->referral_carrier_full)}}</p>
                                            @if($row->referral->status == 'BLOCKED')
                                                <span class="badge alert-danger">{{$row->referral->status}}</span>
                                            @endif
                                        </td>
                                    @endif
                                @if(in_array('Status', $selectedColumns))
                                        <td><span class="badge {{strtolower($row->status->name)}}">{{$row->status->name}}</span></td>
                                @endif
                                    @if(in_array('projected_lien', $selectedColumns))

                                        <td><p>{{$row->projected_lien_date_view}}</p>
                                        </td>
                                    @endif
                                    @if(in_array('follow_up', $selectedColumns))
                                        <td><p><b>{{strtolower($row->follow_up_date)}}</b></p></td>
                                    @endif
                                @if(in_array('days_from_billing', $selectedColumns))
                                    <td><p>{{strtolower($row->finance->collection->days_from_billing)}} days</p></td>
                                @endif
                                @if(in_array('days_from_service', $selectedColumns))
                                    <td><p>{{strtolower($row->finance->collection->days_from_service)}} days</p></td>
                                @endif

                                @if(in_array('Address', $selectedColumns))
                                    <td><p><a href="{{$row->address->link}}" target="{{$row->address->target}}" >{{$row->address->message}}</a></p></td>
                                @endif
                                @if(in_array('Street', $selectedColumns))
                                    <td><p>{{$row->street}}</p></td>
                                @endif
                                @if(in_array('City', $selectedColumns))
                                    <td><p>{{$row->city}}</p></td>
                                @endif
                                @if(in_array('State', $selectedColumns))
                                    <td><p>{{$row->state}}</p></td>
                                @endif
                                @if(in_array('Phone', $selectedColumns))
                                    <td>
                                        @foreach($row->phones as $phone)
                                            <a href="#"><small>{{$phone->phone}}</small> </a>
                                        @endforeach
                                    </td>
                                @endif
                                {{--                                @if(in_array('Invoice', $selectedColumns))--}}
                                {{--                                    <td>--}}
                                {{--                                        @foreach($row->invoices as $invoice)--}}
                                {{--                                            <p>{{$invoice}}</p>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </td>--}}
                                {{--                                @endif--}}

                                @if(in_array('Created by', $selectedColumns))
                                    <td><p>{{$row->user_created->name}}</p></td>
                                @endif
                                @if(in_array('Created At', $selectedColumns))
                                    <td><p class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i>{{$row->created_date}}</p></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div wire:loading>
                        <div class="row">
                        <div class="col-lg-2" style="margin: auto;">
                            <div class="spinner-border text-primary m-1" role="status" >
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div wire:loading.remove>
                        <div class="float-start">
                            Total jobs: {{$list->total()}}<br>

                        </div>
                        <div class="float-end">


                            {{$list->links()}}


                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>

@push('js')
    <script>
        
        $(document).ready(function () {
            $('.select2').select2();
            
            $(document).on('change', '.select-filter', function (e) {
                let model = $(this).data('model');
                let value = $(this).val();
                @this.set('filters.' + model, value);
            })
            
            Livewire.hook('message.processed', (message, component) => {
                $('.select2').select2()
            })
            
        })
        
        function clearReferral () {
            /* $('.select_referral').empty().trigger('change')*/
        }
        
        function clearCarrier () {
            /* $('.select_carrier').empty().trigger('change')*/
        }
    </script>
@endpush