<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Addons\Support\Traits\HasCollections;
use Modules\User\Entities\User;

abstract class CoreModel extends Model {

	use HasCollections;

	public function __construct (array $attributes = [])
	{
		$connection = get_connection();

		if ( isset($connection) ) {
			$this->setConnection($connection);
		}

		parent::__construct($attributes);
	}

	public function user_created ()
	{
		return $this->setConnection('')->belongsTo(User::class, 'created_by');
	}

	public function user_updated ()
	{
		return $this->setConnection('')->belongsTo(User::class, 'updated_by');
	}

}