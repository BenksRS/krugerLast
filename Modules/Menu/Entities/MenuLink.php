<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Casts\EnumCast;

class MenuLink extends Model {

    use HasFactory;

    protected $fillable = ['link_id', 'title', 'icon', 'url', 'open', 'options', 'order', 'visible', 'active'];

    protected $casts    = [
        'options' => 'array',
        'visible' => EnumCast::class,
        'active'  => EnumCast::class,
    ];

    public function parent ()
    {
        return $this->belongsTo(MenuLink::class, 'link_id');
    }

    public function children ()
    {
        return $this->hasMany(MenuLink::class, 'link_id');
    }

    public function group ()
    {
        return $this->belongsTo(MenuLinkGroup::class, 'id', 'link_id');
    }

    public function scopeBuildItems ($query)
    {
        return $query->with(['children'])->whereNull('link_id');

        return $query->with([
            'group' => function ($query) {
                $query->where('visible', 'Y');
            },
        ]);
    }

    public function collection ($items)
    {
        $collection = collect();

        $items  = $items->load(['items' => fn ($query) => $query->where('group_id', 1)])->sortBy('order');
        $parent = $items;

        $parent = $parent->map(function ($item) use ($items) {
            $item->children = $items->where('parent_id', $item->id)->values()->toArray();

            return $item;
        })->filter(fn ($item) => $item->parent_id === NULL);

        dump($parent->values()->toArray());

        /*        foreach ( $items as $item ) {
                    $collection->push($item);
                    if ( $item->parent_id ) {
                        $collection[$item->parent_id]['childs'] = $item->toArray();
                    }
                    dump($item->toArray());
                }*/

        /*        foreach ( $items as $item ) {
                    $collection->push($item);
                    $collection = $collection->merge($this->collection($item->children));
                }*/

        return $collection;
    }

}
