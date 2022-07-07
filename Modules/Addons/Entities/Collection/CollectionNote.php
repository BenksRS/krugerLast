<?php

namespace Modules\Addons\Entities\Collection;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\CoreModel;

class CollectionNote extends CoreModel {

	protected $fillable = ['text'];

	public function collect ()
	{
		return $this->morphTo('collect');
	}

}