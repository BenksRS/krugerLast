<div class="dd-header-actions ms-auto me-5 d-flex gap-3">
	<div class="action-item">
		<div class="form-check form-switch">
			<input class="form-check-input" type="checkbox" role="switch" id="active-in1-{{ $link->id }}" wire:change="updateItemGroup({{$link}})">
		</div>
	</div>

	<div class="action-group border-start border-end d-flex px-3 gap-3">
		<div class="action-item" wire:click="deleteLink({{ $link }})">
			<i class="bx bx-trash text-danger"></i>
		</div>
		<div class="action-item d-none">
			<i class="bx bx-edit text-info"></i>
		</div>
	</div>

</div>