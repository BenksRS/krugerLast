<div>
    <div class="boxrigthsched">



        <div class="hstack m-2">
            <div class="addresschoice">
                @foreach($addresses['all'] as $address)
                    <a href="#"
                       @class([
                           'link-dark user-select-none',
                           'text-info' => $addresses['selected']['id'] == $address['id'],
                        ])
                       wire:key="address-{{ $address['id'] }}"
                       wire:click="changeAddress({{ $address['id'] }})"><i class="bx bxs-home"></i>{{ $address['name'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="hstack m-2">
            <div>From <span class="fw-semibold">( <small>{{$originAddress }}</small> )</span></div>
        </div>
        <hr>
        @foreach($statusList as $data)
            <div class="form-check form-check-inline user-select-none" wire:key="check-status-{{ $data->id }}">
                <input class="form-check-input" type="checkbox" id="check-status-{{ $data->id }}" wire:model="checklist.{{ $data->id }}">
                <label class="form-check-label" for="check-status-{{ $data->id }}">
                    <div class="{{ $data->class }} badge rounded-pill text-uppercase">
                        {{ $data->name }}
                    </div>
                </label>
            </div>
        @endforeach
        <hr>
        Total Jobs({{$this->totalJobs}})
        <div class="jobsOpen"  wire:key="openjobs" wire:sortable-group.item-group="openJobs" >
            <div class="accordion accordion-flush" id="accordionCitys" >


                @if(count($list_city) > 0)
                    <?php  $id=1;?>
                    <div wire:loading>
                        <div class="spinner-border text-primary col-lg-12" role="status">
                        </div>
                    </div>
                    <div wire:loading.remove>
                        @foreach($list_city->sortBy('order') as $groupCity)
                            <?php  $scroll=($id*49)-49; $id++;?>
                            <div class="accordion-item">

                                <h2 class="accordion-header" id="flush-heading-{{$groupCity->id}}">
                                    <button class="accordion-button fw-medium collapsed" type="button"  wire:ignore.self  data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$groupCity->id}}" aria-expanded="true" aria-controls="flush-collapse-{{$groupCity->id}}" data-move="{{$scroll}}" >
                                        <span style="font-size: 10px;">{{$groupCity->label}} ({{$groupCity->total}}) - {{$groupCity->milhas}}</span>
                                    </button>
                                </h2>
                                <div id="flush-collapse-{{$groupCity->id}}" wire:ignore.self class="accordion-collapse collapse"  aria-labelledby="flush-heading-{{$groupCity->id}}" data-bs-parent="#accordionCitys">
                                    <div class="accordion-body text-muted">

                                        <div wire:loading>
                                            <div class="spinner-border text-primary col-lg-12" role="status">
                                            </div>
                                        </div>
                                        <div wire:loading.remove>
                                            {{-- JOBS --}}
                                            @if($groupCity->total > 0)

                                                <?php $alljobs=$this->getOpenJobs($groupCity->jobs, $groupCity->city, $groupCity->state) ?>
                                                        <!--                                                    --><?php //dd($alljobs)?>
                                                @foreach($alljobs->sortBy('order') as $item)


                                                    <div class="open_job alert {{$item->job->lastStatus->class}}" wire:key="open__{{$item->job->id}}" wire:sortable-group.item="{{$item->job->id}}" >
                                                        <div class="row">
                                                            <?php
                                                            $fontsize=10;
                                                            //                                            $length=

                                                            if(strlen($item->job->full_name) > 34){
                                                                $fontsize=$fontsize-2;
                                                            }
                                                            ?>

                                                            <div class="col-lg-12 blackfont"  style="font-size: {{$fontsize}}px">
                                                                {{ $item->job->full_name }}
                                                            </div>

                                                            <div class="col-lg-12 whitefont mt-1" style="font-size: 9px">
                                                                <?php $countOpen=0;?>
                                                                @foreach($item->job->job_types as $job_types)
                                                                    <?php $countOpen++;?>
                                                                    @if($countOpen == 1)
                                                                        {{$job_types->name}}
                                                                    @else
                                                                        {{" / $job_types->name"}}
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="col-lg-12 blackfont mt-1">

                                                                {{--                                                                                                                        <span class="float-start" style="font-size: 9px">{{ isset($item->job->phones->first()->phone) ? $item->job->phones->first()->phone : 'No phone'}}</span>--}}
                                                                <span class="float-end "  style="font-size: 8px">   ({{$item->job->referral->company_entity}})</span>
                                                            </div>
                                                            <div class="col-lg-12 whitefont mt-1" style="font-size: 10px">
                                                                <span class="float-start">{{strtoupper($item->job->city)}} - {{$item->job->state}}</span>
                                                                <span class="float-end">   ({{$item->milhas}})</span>
                                                            </div>



                                                        </div>
                                                    </div>
                                                @endforeach

                                        </div>

                                        @endif







                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                @endif
            </div>
            <div style="height: 800px">

            </div>
        </div>

    </div>
</div>
