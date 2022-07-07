@php
	$user = \Modules\User\Entities\User::find(1);

	$options = ['Felipe' => 'Felipe', 'Michel' => 'Michel', 'Vieira' => 'Vieira'];

	$names = [
		'Group 1' => ['Felipe' => 'Felipe'],
		'Group 2' => ['Michel' => 'Michel', 'Vieira' => 'Vieira'],
	];

@endphp

<x-layouts.app>

	<x-card></x-card>

	<x-form route="auth.login" method="PUT" :model="$user" class="asdasd">
		<div class="mb-3">
			<x-form-input type="text" name="name" label="Email" />
		</div>
		<div class="mb-3">
			<x-form-select name="selected[]" label="Name" :options="$names" class="select2" />
		</div>
		<div class="mb-1">
			<x-form-checkbox type="checkbox" name="selected[]" label="Name" :options="$options" />
		</div>
		<x-button value="Log In" />
	</x-form>
</x-layouts.app>

{{--<x-input></x-input>
<x-ui-menu-item></x-ui-menu-item>
<x-ui-card></x-ui-card>--}}



