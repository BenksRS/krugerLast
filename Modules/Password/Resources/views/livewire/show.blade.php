<div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				
				<div class="card-body">
					
					<div class="row">
						<div class="col-12">
							<div class="d-flex flex-wrap justify-content-between">
		
								<div class="mb-3 ms-auto">
									<div class="btn-group">
										<button class="btn btn-success btn-label waves-light" type="button"
										        wire:click="$emit('passwordForm')">
											<i class="bx bx-plus label-icon"></i> New Password
										</button>
									</div>
								</div>
							</div>
						</div>
					
					<form class="d-block">
						<div class="position-relative col-lg-12">
							<input type="text" class="form-control" placeholder="Search here.." wire:model.debounce.500ms="search" type="search">
						</div>
					</form>
					
					<div wire:loading.flex wire:target="search" class="justify-content-center mt-3">
						<div class="spinner-border" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
					</div>
					
					<div class="table-responsive mt-3" wire:loading.remove wire:target="search">
						<table class="table table-hover table-bordered listtable mb-0 align-middle">
							<thead>
								<tr>
									<th scope="col" class="text-center">ID</th>
									<th scope="col">Name</th>
									<th scope="col">Username</th>
									<th scope="col">Password</th>
									<th scope="col">URL</th>
									<th scope="col">Created by</th>
									<th scope="col">Updated by</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								@forelse($passwords as $password)
									<tr wire:key="password-{{ $password->id }}">
										<th scope="row" class="text-center" style="width: 100px">{{ $password->id }}</th>
										<td>{{ $password->name }}</td>
										<td>{{ $password->username }}</td>
										<td>{{ $password->password }}</td>
										<td style="min-width: 400px; max-width: 400px">
											<a href="{{ $password->url }}" target="_blank">{{ $password->url }}</a>
										</td>
										<td style="width: 200px">{{ $password->user_created->name }}</td>
										<td style="width: 200px">{{ $password->user_updated->name }}</td>
										<td style="width: 150px">
											<div class="d-grid">
												<button class="btn btn-info btn-label waves-light" type="button"
												        wire:click="$emit('passwordForm', {{ $password->id }})">
													<i class="bx bx-edit label-icon"></i> Edit
												</button>
											</div>
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="7" class="text-center">
											No items found
										</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					
					</div>
				</div>
			</div>
		
		
		</div>
	</div>
	
	@livewire('password::modal.form', key('password-modal-form'))
</div>
