<div>
	
	
	{{--@dump($grids_header)--}}
	<div class="card" wire:sortable-group="schedulleJobs">
		<div class="card-body" style="padding: 0px!important;">
			<div class="boxleftsched">
				<div class="headerControls">
					<div class="row">
						<div class="col-lg-5">
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
						<div class="col-lg-4 mt-2">
							@if(session()->has('schedupdate'))
								<div class="alert alert-{{session('schedupdate')['class']}}" x-init="setTimeout(() => show = false, 3000)">
									{!! nl2br(session('schedupdate')['message']) !!}
								</div>
								<script>
                                    setTimeout(function () {
                                        $('.alert-{{session('schedupdate')['class']}}').fadeOut('fast')
                                    }, 2000)
								</script>
							@endif
							@if(session()->has('schederror'))
								<div class="alert alert-{{session('schederror')['class']}}" x-init="setTimeout(() => show = false, 3000)">
									{!! nl2br(session('schederror')['message']) !!}
								</div>
								<script>
                                    setTimeout(function () {
                                        $('.alert-{{session('schederror')['class']}}').fadeOut('fast')
                                    }, 4000)
								</script>
							@endif
						</div>
						<dic class="col-lg-3 float-end">
							@foreach($statusList->sortby('ordem') as $data)
								<div class="form-check form-check-inline user-select-none font" wire:key="check-status-{{ $data->id }}">
									<input class="form-check-input" type="checkbox" id="check-status-{{ $data->id }}" wire:model="checklist.{{ $data->id }}">
									<label class="form-check-label" for="check-status-{{ $data->id }}">
										<div class="{{ $data->class }} badge rounded-pill text-uppercase">
											{{ $data->name }}
										</div>
									</label>
								</div>
							@endforeach
						</dic>
					
					
					</div>
				
				
				</div>
				<div class="schedTechs ">
					<div class="schedTechbox"></div>
					<div class="schedTechboxContent moveall">
						@foreach($techs as $tech)
							<div class="schedTechbox">
								
								<div class="text-muted m-4">
									<p>
									<h5>{{$tech->user->name}}</h5>
									<span>Technician</span></p>
								</div>
							</div>
						@endforeach
					</div>
				</div>
				<div class="schedsgrid">
					<div class="schedsHeaderContent moveyall">
						<div class="lineWrap ">
							@foreach($grids_header as $gridH)
								<div class="schedboxHeader">
									<div class="text-muted text-center mt-4">
										<h4>{{$gridH->time}}</h4>
										<span>{{$gridH->format}}</span>
									</div>
								
								</div>
							@endforeach
						</div>
					</div>
					<div class="schedsgridContent moveall moveyall">
						
						@foreach($techs as $tech)
							<div wire:loading class="lineWrap animated-background ">
							
							</div>
							<div class="lineWrap" wire:key="line_tech-{{$tech->id}}" wire:loading.remove>
                                    <?php
                                    $jobs = $list_schedulleds->where('tech_id', $tech->user->id);

                                    ?>
								
								
								@foreach($grids as $grid)
                                        <?php
                                        $jobs_grid  = $jobs->where('start_date', "$grid");
                                        $count_jobs = count($jobs_grid);
                                        ?>
									<div class="schedbox" wire:key="tech_{{$tech->user->id}}_grid_{{$grid}}" wire:sortable-group.item-group="techid_{{$tech->user->id}}_grid_{{$grid}}">
										{{--                                <div  wire:sortable-group.item-group.item-group="grid-{{$grid}}">--}}
										
										
										@if($count_jobs > 0)
											
											@foreach($jobs_grid as $job_grid)
												
												@if(!in_array($job_grid->assignment->status_id, [7,8,23]))
													<div class="scheduled_job alert {{$job_grid->assignment->status->class}} {{($this->jobRoute == $job_grid->assignment->id)? ' job_route': ''}}" wire:key="techid_{{$tech->user->id}}_grid_{{$grid}}_{{$job_grid->assignment->id}}" wire:sortable-group.item="{{$job_grid->assignment->id}}">
														
														<div class="row">
															<div class="col-lg-12 blackfont">
																#{{ $job_grid->assignment->id }}
                                                                @if( !empty($job_grid->assignment->tags->toArray()) && in_array(11, collect($job_grid->assignment->tags)->pluck('id')->all()))
                                                                    <div class="position-absolute top-0 end-0">
                                                                        <i class="bx bx-purchase-tag-alt" style="font-size: 20px;"></i>
                                                                    </div>
                                                                @endif
															</div>
															
															<div class="col-lg-12 whitefont" style="font-size: 9px">
																@foreach($job_grid->assignment->job_types as $job_types)
                                                                        <?php $count = 0;$count ++; ?>
																	@if($count == 1)
																		{{$job_types->name}}
																	@else
																		{{" / $job_types->name"}}
																	@endif
																@endforeach
															</div>
															<div class="col-lg-12 blackfont" style="font-size: 9px">
																{{$job_grid->assignment->city}} - {{$job_grid->assignment->state}}
															</div>
															
															<div class="col-lg-12">
																<button type="button" class="btn btn-sm btn-warning waves-effect waves-light" wire:loading.attr="disabled" wire:click="$emit('changeRoute',['{{$job_grid->assignment->destination}}', '{{$job_grid->assignment->id}}' ])">
																	<i class="bx bx-car"></i></button>
																{{--                                                        <button type="button" class="btn btn-sm btn-info waves-effect waves-light"><i class="bx bx-search"></i></button>--}}
																{{--                                                        <button type="button" class="btn btn-sm btn-danger waves-effect waves-light" ><i class="bx bx-trash"></i></button>--}}
															</div>
														
														</div>
													
													</div>
												@endif
											@endforeach
										@endif
									</div>
									{{--                            </div>--}}
								
								@endforeach
							
							</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="boxrigthsched">
				<div class="hstack m-2">
					<div class="addresschoice">
						@foreach($addresses['all'] as $address)
							<a href="#"
							   @class([
								   'link-dark user-select-none',
								   'text-info' => $this->jobRoute == $address['id'],
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
				
				<div class="total_jobs {{$showSystem == TRUE ? 'hide' : '' }}">
					<button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-start" wire:click.prevent="toogleSystem">
						<i class="bx bx-loader-circle font-size-16 align-middle "></i> SystemJobs
					</button>
					Total Jobs({{$this->totalJobs}}) <br>
					
					
					<hr>
					<div class="jobsOpen" wire:key="openjobs" wire:sortable-group.item-group="openJobs">


                        <?php
                        $insideJobs = $this->getNewOpenJobs();
                        ?>
						
						
						{{-- JOBS --}}
						@if($insideJobs)
							<div wire:loading.remove>
								
								@foreach($insideJobs->sortBy('order') as $item)
									
									<div class="open_job alert {{$item->job->status->class}}" wire:key="open__{{$item->job->id}}" wire:sortable-group.item="{{$item->job->id}}">
										<div class="row">
                                                <?php
                                                $fontsize = 10;
                                                //                                            $length=

                                                if ( strlen($item->job->full_name) > 34 ) {
                                                    $fontsize = $fontsize - 2;
                                                }
                                                ?>
											<div class="col-lg-12 blackfont" style="font-size: {{$fontsize}}px">
												{{ $item->job->full_name }}
												@if( !empty($item->job->tags->toArray()) && in_array(11, collect($item->job->tags)->pluck('id')->all()))
													<div class="position-absolute top-0 end-0">
														<i class="bx bx-purchase-tag-alt" style="font-size: 20px"></i>
													</div>
												@endif
											</div>
											
											<div class="col-lg-12 whitefont mt-1" style="font-size: 9px">
                                                    <?php $countOpen = 0; ?>
												@foreach($item->job->job_types as $job_types)
                                                        <?php $countOpen ++; ?>
													@if($countOpen == 1)
														{{$job_types->name}}
													@else
														{{" / $job_types->name"}}
													@endif
												@endforeach
											</div>
											<div class="col-lg-12 blackfont mt-1">
												
												<span class="float-start" style="font-size: 9px">{{ isset($item->job->phones->first()->phone) ? $item->job->phones->first()->phone : 'No phone'}}</span>
												
												<span class="float-end " style="font-size: 8px"> ({{$item->job->referral_carrier }})</span>
											
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
				
				{{--                SYSTEM JOBS --}}
				<div class="system_jobs {{$showSystem == TRUE ? '' : 'hide' }}">
					<button type="button" class="btn btn-sm btn-secondary  waves-effect waves-light  me-2 float-start" wire:click.prevent="toogleSystem">
						<i class="bx bx-loader-circle font-size-16 align-middle "></i> OpenJobs
					</button>
					System
					<hr>
					<div class="jobsOpen" wire:key="openjobs" wire:sortable-group.item-group="openJobs">
						
						@if(count($list_systemCity) > 0)
                                <?php $id = 1; ?>
							
							@foreach($list_systemCity->sortBy('order') as $groupCity)
                                    <?php
                                    $insideJobs = $this->getSystemJobs($groupCity->city ?? '', $groupCity->state ?? '');
                                    ?>
								
								
								{{-- JOBS --}}
								@if($insideJobs)
									
									@foreach($insideJobs->sortBy('order') as $item)
										
										<div class="open_job alert {{$item->job->status->class}}" wire:key="open__{{$item->job->id}}" wire:sortable-group.item="{{$item->job->id}}">
											<div class="row">
                                                    <?php
                                                    $fontsize = 10;
                                                    //                                            $length=

                                                    if ( strlen($item->job->full_name) > 34 ) {
                                                        $fontsize = $fontsize - 2;
                                                    }
                                                    ?>
												
												<div class="col-lg-12 blackfont" style="font-size: {{$fontsize}}px">
													{{ $item->job->full_name }}
												</div>
												
												<div class="col-lg-12 whitefont mt-1" style="font-size: 9px">
                                                        <?php $countOpen = 0; ?>
													@foreach($item->job->job_types as $job_types)
                                                            <?php $countOpen ++; ?>
														@if($countOpen == 1)
															{{$job_types->name}}
														@else
															{{" / $job_types->name"}}
														@endif
													@endforeach
												</div>
												<div class="col-lg-12 blackfont mt-1">
													
													<span class="float-start" style="font-size: 11px">{{ $item->job->scheduling->start_hour}}</span>
													
													{{--                                                                                <span class="float-end "  style="font-size: 8px"> ({{$item->job->referral_carrier }})</span>--}}
												
												</div>
												<div class="col-lg-12 whitefont mt-1" style="font-size: 10px">
													<span class="float-start">{{strtoupper($item->job->city)}} - {{$item->job->state}}</span>
													<span class="float-end">   ({{$item->milhas}})</span>
												</div>
											
											
											</div>
										</div>
									@endforeach
								
								@endif
							
							@endforeach
						
						@endif
						
						<div style="height: 800px">
						
						</div>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</div>


</div>
