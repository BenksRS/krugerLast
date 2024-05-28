
<tr wire:key="tech-{{ $tech->id }}" wire:sortable.item="{{ $tech->id }}" data-id="{{ $tech->id }}">
	<td class="handle">
		<i class="bx bx-move"></i> <!-- Ícone de movimentação -->
	</td>
	<td><strong>{{ $tech->user->name }}</strong></td>
	<td>
		<span>{{ $tech->base ?? 'N/D' }}</span> <!-- Texto clicável para abrir a modal -->
	</td>
	<td class="check-active">
		<div class="d-flex justify-content-center align-items-center">
			<div class="form-check form-switch form-switch-md">
				<input class="form-check-input" type="checkbox" wire:model="active" wire:change="changeActive">
			</div>
		</div>
	</td>
	<!-- Modal -->

</tr>

