
<x-layouts.basic>
	<div class="p-4 min-vh-100 d-flex">
		@include('scheduling::timeline')
	</div>

	<div class="p-5 min-vh-100 d-none">


		<x-card class="schedule-container w-100 m-xl-0">

			<div class="d-flex flex-column h-100">


				<div class="p-4 border-bottom">
					<div class="d-sm-flex flex-wrap text-center text-sm-start align-items-center">
						<div class="d-sm-flex flex-wrap gap-2">
							<div class="btn-group" role="group" aria-label="Basic example">
								<button type="button" class="btn btn-primary btn-rounded">
									<i class="calendar-icon ic-arrow-line-left mdi mdi-chevron-left" data-action="move-prev"></i>
								</button>
								<button type="button" class="btn btn-primary btn-rounded">
									<i class="calendar-icon ic-arrow-line-right mdi mdi-chevron-right" data-action="move-next"></i>
								</button>
							</div>
						</div>
						<h5 class="m-0 ms-3 fw-bold">7 February
							<span class="ms-1 text-secondary opacity-50 fw-normal">Today</span>
						</h5>
					</div>
				</div>


				<div class="timeline-control">
					<div class="control-row">
						<div class="control-column"></div>
						<div class="control-column">

							<div class="timeline-box timeline-label" data-scroll-sync="timeline">
								<div class="box-content">
									<div class="label-resource">
										@for($i=0; $i <= 23; $i++)
											<div role="presentation" class="slot-data">
												{{ $i <= 12 ? $i : $i - 12 }}:00
												<span>{{ $i < 12 ? 'AM' : 'PM' }}</span>
											</div>
										@endfor
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="control-row">
						<div class="control-column">

							<div class="timeline-box timeline-collections" data-scroll-sync="timeline">
								<div class="box-content">
									<div class="collections-resource">
										@for($i=0; $i <= 23; $i++)
											<div role="presentation" class="slot-data">
												User Name
												<span>Technician</span>
											</div>
										@endfor
									</div>
								</div>
							</div>

						</div>
						<div class="control-column">
							<div class="timeline-box timeline-events" data-scroll-sync="timeline">
								<div class="box-content">
									<div class="events-resource events-resource--vertically">
										@for($i=0; $i <= 23; $i++)
											<div role="presentation" class="slot-data">
												<span></span>
												<span></span>
											</div>
										@endfor
									</div>
									<div class="events-resource events-resource--horizontally">
										@for($i=0; $i <= 23; $i++)
											@php
												$colors = ['primary', 'success', 'danger', 'warning', 'info'];
											@endphp
											<div role="presentation" class="slot-data">
												<div
													class="btn-group"
													draggable="true"
													style="grid-column: {{ rand(1, 6) }} / span {{ rand(2, 3) }}">
													<div
														class="dropdown-toggle alert alert-{{ $colors[rand(0,4)] }}"
														id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">........
													</div>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														<li><a class="dropdown-item" href="#">Menu item</a></li>
														<li><a class="dropdown-item" href="#">Menu item</a></li>
														<li><a class="dropdown-item" href="#">Menu item</a></li>
													</ul>

												</div>
												<div
													data-bs-toggle="modal" href="#exampleModalToggle" role="button"
													draggable="true"
													class="alert alert-{{ $colors[rand(0,4)] }}" role="alert" style="grid-column: {{ rand(9, 14) }} / span {{ rand(2, 3) }}">
													...
												</div>
												<div
													data-bs-toggle="modal" href="#exampleModalToggle" role="button"
													draggable="true"
													class="alert alert-{{ $colors[rand(0,4)] }}" role="alert" style="grid-column: {{ rand(17, 22) }} / span {{ rand(2, 3) }}">
													...
												</div>
												<div
													data-bs-toggle="modal" href="#exampleModalToggle" role="button"
													draggable="true"
													class="alert alert-{{ $colors[rand(0,4)] }}" role="alert" style="grid-column: {{ rand(25, 30) }} / span {{ rand(2, 3) }}">
													...
												</div>
												<div
													data-bs-toggle="modal" href="#exampleModalToggle" role="button"
													draggable="true"
													class="alert alert-{{ $colors[rand(0,4)] }}" role="alert" style="grid-column: {{ rand(33, 40) }} / span {{ rand(2, 3) }}">
													...
												</div>
											</div>
										@endfor
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</x-card>


		<x-card class="treeview-container m-0 ms-xl-3">
			<div class="alert alert-primary" role="alert">
				A simple primary alert with
				<a href="#" class="alert-link">an example link</a>. Give it a click if you like.
			</div>
			<div class="alert alert-secondary" role="alert">
				A simple secondary alert with
				<a href="#" class="alert-link">an example link</a>. Give it a click if you like.
			</div>
			<div class="alert alert-success" role="alert">
				A simple success alert with
				<a href="#" class="alert-link">an example link</a>. Give it a click if you like.
			</div>
			<div class="alert alert-danger" role="alert">
				A simple danger alert with
				<a href="#" class="alert-link">an example link</a>. Give it a click if you like.
			</div>
			<div class="alert alert-warning" role="alert">
				A simple warning alert with
				<a href="#" class="alert-link">an example link</a>. Give it a click if you like.
			</div>
			<div class="alert alert-info" role="alert">
				A simple info alert with
				<a href="#" class="alert-link">an example link</a>. Give it a click if you like.
			</div>
			<div class="alert alert-light" role="alert">
				A simple light alert with
				<a href="#" class="alert-link">an example link</a>. Give it a click if you like.
			</div>
			<div class="alert alert-dark" role="alert">
				A simple dark alert with
				<a href="#" class="alert-link">an example link</a>. Give it a click if you like.
			</div>
		</x-card>


	</div>

	<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header py-3 px-4 border-bottom-0">
					<h5 class="modal-title" id="modal-title">Edit Event</h5>

					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>

				</div>
				<div class="modal-body p-4">
					<form class="needs-validation" name="event-form" id="form-event" novalidate="">
						<div class="row">
							<div class="col-12">
								<div class="mb-3">
									<label for="event-title" class="form-label">Event Name</label>
									<input class="form-control" placeholder="Insert Event Name" type="text" name="title" id="event-title" required="" value="">
									<div class="invalid-feedback">Please provide a valid event name</div>
								</div>
							</div>
							<div class="col-12">
								<div class="mb-3">
									<label for="event-category" class="form-label">Category</label>
									<select class="form-control form-select" name="category" id="event-category">
										<option selected=""> --Select--</option>
										<option value="bg-danger">Danger</option>
										<option value="bg-success">Success</option>
										<option value="bg-primary">Primary</option>
										<option value="bg-info">Info</option>
										<option value="bg-dark">Dark</option>
										<option value="bg-warning">Warning</option>
									</select>
									<div class="invalid-feedback">Please select a valid event category</div>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-6">
								<button type="button" class="btn btn-danger" id="btn-delete-event">Delete</button>
							</div>
							<div class="col-6 text-end">
								<button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


</x-layouts.basic>
