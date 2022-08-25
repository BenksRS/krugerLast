<ol class="dd-list">
	@foreach($children as $i => $child)
		<li class="dd-item" data-id="{{ $child->id }}" data-parent="{{ $child->link_id }}">
			<div class="card border m-0">
				<div class="dd-handle border-end"></div>
				<div class="dd-header">
					<div class="dd-header-collapse" role="button" aria-expanded="false" data-bs-toggle="collapse" data-bs-target="#link-{{ $child->id }}"></div>
					<div class="dd-header-title">{{ $child->title }}</div>
					@include('menu::build.list.partials.actions')
				</div>
				<div class="border-top dd-body collapse" id="link-{{ $child->id }}">
					<div class="card-body">
						@include('menu::build.form.submenu')
					</div>
				</div>
			</div>
		</li>
	@endforeach
</ol>