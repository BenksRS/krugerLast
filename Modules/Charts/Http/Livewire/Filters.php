<?php

namespace Modules\Charts\Http\Livewire;

use Livewire\Component;
use Modules\Charts\Http\Livewire\Filters\WithFilters;

class Filters extends Component {

	use WithFilters;

	protected function addFields ()
	{
		return [
			'referral' => [
				'type'    => 'radio',
				'name'    => 'referral',
				'input'   => [
					'referral'          => 'Referral',
					'referral_carriers' => 'Referral / Carrier',
					'referral_types'    => 'Referral Type',
				],
				'checked' => 'referral',
			],
		];
	}

	public function render ()
	{
		return view('charts::livewire.filters');
	}

}
