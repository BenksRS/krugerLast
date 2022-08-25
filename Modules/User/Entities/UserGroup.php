<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Menu\Entities\MenuLink;
use Modules\Menu\Entities\MenuLinkGroup;

class UserGroup extends Model {

    protected $fillable = ['name', 'active', 'privilege'];

    public function users ()
    {
        return $this->hasMany(User::class);
    }

    public function menuLinks() {
        return $this->belongsToMany(MenuLink::class, MenuLinkGroup::class, 'group_id', 'link_id', 'id', 'id');
    }
}
