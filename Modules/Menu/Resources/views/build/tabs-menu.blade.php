<div class="row">
	<div class="col-lg-2">
		<div class="menu-groups">
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

				<a class="nav-link {{($groupActive == 0) ? 'active' : ''}}" wire:click.prevent="setGroup('0')" href="#v-pills-menus" role="tab" data-bs-toggle="tab">
					<p class="fw-bold my-2">Menus</p>
				</a>

				@foreach($groups as $group)
					<a class="nav-link {{($groupActive == $group->id) ? 'active' : ''}}"
					   wire:click.prevent="setGroup({{ $group->id }})" href="#v-pills-{{$group->name}}"
					   role="tab" data-bs-toggle="tab">
						<p class="fw-bold my-2">{{ $group->name }}</p>
					</a>
				@endforeach

			</div>
		</div>
	</div>
	<div class="col-lg-10">
		<div class="card">
			<div class="card-body">

				<div class="tab-content" id="v-pills-menu">
					<div class="tab-pane {{($groupActive == 0) ? 'active show' : 'fade'}} " id="v-pills-menu" role="tabpanel" aria-labelledby="v-pills-menu-tab">

										<div class="row mb-3">
											<div class="col">
												<button type="button" class="btn btn-success waves-effect waves-light"
												        wire:click.prevent="toogleForm"
															        data-bs-toggle="modal" data-bs-target="#modal-link"
												>
													<i class="mdi mdi-plus me-1"></i> Add New Link
												</button>
												<div class="border-bottom mt-3"></div>
												@if($showForm)
													<div class="form-link">
														<form wire:submit.prevent="createLink">
															<div class="modal-body">

																<div class="row">
																	<div class="col-md-4">
																		<label for="inputTitle" class="form-label">Title</label>
																		<input type="text" class="form-control" id="inputTitle" wire:model="data.title">
																	</div>
																	<div class="col-md-4">
																		<label for="inputIcon" class="form-label">Icon</label>
																		<input type="text" class="form-control" id="inputIcon" wire:model="data.icon">
																	</div>
																	<div class="col-md-4">
																		<label for="inputParent" class="form-label">Parent</label>
																		<select id="inputParent" class="form-control" wire:model="data.link_id">
																			@foreach($parents  as $id => $parent)
																				<option value="{{ $id }}">{{ $parent }}</option>
																			@endforeach
																		</select>
																	</div>
																</div>

																<div class="d-flex flex-column mt-4">
																	<div class="border w-100 p-4">
																		<div class="row">
																			<div class="col-md-12">
																				<label for="inputUrl" class="form-label">URL</label>
																				<input type="text" class="form-control" id="inputUrl" wire:model="data.url">
																			</div>
																			<div class="col-md-12 mt-4">
																				<label for="inputOpen" class="form-label">Open Link in</label>
																				<div>
																					<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
																						<input type="radio" class="btn-check" id="open-in1-" name="data.open[]" wire:model.defer="data.open" value="_blank">
																						<label class="btn btn-outline-primary" for="open-in1-">New Tab</label>

																						<input type="radio" class="btn-check" id="open-in2-" name="data.open[]" wire:model.defer="data.open" value="_self">
																						<label class="btn btn-outline-primary" for="open-in2-">Same Tab</label>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>

																</div>

															</div>
															<div class="modal-footer">
																<button type="submit" class="btn btn-primary">Save changes</button>
																<button type="button" class="btn btn-secondary" wire:click="toogleForm">Close</button>
															</div>
														</form>
													</div>
												@else
													@livewire('menu::show-menulist', key('menu_show_menulist'))
												@endif

											</div><!-- end col-->
										</div>




					</div>
				</div>

					@foreach($groups as $group)
					<div class="tab-content" id="v-pills-{{$group->name}}">
						<div class="tab-pane {{($groupActive == $group->id) ? 'show' : 'fade'}} " id="v-pills-{{$group->name}}" role="tabpanel" aria-labelledby="v-pills-{{$group->name}}-tab">
							@livewire('menu::show-tab', ['group' => $group->id], key('menu_show_tab_'.$group->id))
						</div>
					</div>
					@endforeach

			</div>
		</div>
	</div>
</div>