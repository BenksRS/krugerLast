<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Casts\EnumCast;
use Modules\User\Entities\UserGroup;

class MenuLinkGroup extends Model {

    use HasFactory;

    protected $fillable = ['group_id', 'link_id', 'model_type', 'model_id', 'order', 'visible'];

    protected $casts    = [
        'visible' => EnumCast::class,
        'active'  => EnumCast::class,
    ];

    public function setLinksAttribute ($value)
    {
        $links = [];
        foreach ( $value as $key => $link ) {
            $links[] = [
                'id'      => $link['id'],
                'order'   => $key + 1,
                'visible' => $link['visible'] ?? 'Y',
            ];
        }

        $this->attributes['links'] = json_encode($links);
    }

    public function link ()
    {
        return $this->belongsTo(MenuLink::class, 'link_id');
    }

    public function group ()
    {
        return $this->belongsTo(UserGroup::class, 'group_id');
    }

}
