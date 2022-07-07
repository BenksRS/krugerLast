<?php

namespace Modules\Addons\Entities\Collection;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\CoreModel;

class CollectionPhone extends CoreModel {

	protected $fillable = ['contact', 'phone', 'preferred'];



	public function collect ()
	{
		return $this->morphTo();
	}

}