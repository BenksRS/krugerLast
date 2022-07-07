<?php

namespace Modules\Addons\Support\Traits;

use Modules\Addons\Entities\Authorization;
use Modules\Addons\Entities\Collection\{
	CollectionAuthorization,
	CollectionNote,
	CollectionPhone,
};
use Modules\Addons\Support\Collectable;

trait HasCollections {

	/**
	 * @param $relation
	 *
	 * @return Collectable
	 */
	public function collection ($relation): Collectable
	{
		return new Collectable($this, $relation);
	}

	public function phones ()
	{
		return $this->morphMany(CollectionPhone::class, 'collect')->orderBy('preferred', 'asc');
	}

	public function notes ()
	{
		return $this->morphMany(CollectionNote::class, 'collect');
	}

	public function authorizations ()
	{
		return $this->morphToMany(
			Authorization::class,
			'collect',
			CollectionAuthorization::class,
		)->withPivot(['active'])->withTimestamps();
	}

	/*	public function collections22 ()
		{
			return $this->morphToMany(
				CollectionAuthorization::class,
				'collect',
				ReferralCollection::class,
				'referral_id',
				'collect_id', '', '', TRUE)
				//->with('authorization')
				//->withTimestamps();
				;
		}*/

}