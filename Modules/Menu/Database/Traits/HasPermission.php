<?php

namespace Modules\Menu\Database\Traits;

use Modules\Menu\Entities\MenuPermission;

trait HasPermission {

    public function permission ()
    {
        return $this->morphOne(MenuPermission::class, 'model');
    }

}