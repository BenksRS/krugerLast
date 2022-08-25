<?php

namespace Modules\Menu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Core\Http\Controllers\AdminController;
use Modules\Menu\Entities\MenuLinkGroup;
use Modules\Menu\Entities\MenuLink;
use Modules\Menu\Facades\Menu as MenuManager;

class MenuController extends AdminController {

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index (MenuLink $menu, MenuLinkGroup $menuItem)
    {

        /*        $user = auth()->user();

                dump($menu->buildItems()->get()->toArray());*/

        /*        foreach ( MenuManager::make() as $item ) {
                    $db = $menu->create($item);

                    if ( !empty($item['children']) ) {
                        $db->children()->createMany($item['children']);
                    }

                }*/

        /*        foreach ( MenuManager::make() as $item ) {
                    $db = $menu->updateOrCreate([
                        'name' => $item['name'],
                    ], $item);

                    if ( !empty($item['children']) ) {
                        $db->children()->createMany($item['children']);
                    }

                }*/

        /*        $db        = $menuItems->updateOrCreate(
                    ['group_id' => 1],
                    ['name' => 'Dashboard', 'text' => 'Dashboard2']
                )->links()->sync([2 => ['visible' => false],1])->save();

                $menuLinks  = $menu->get();
                $collection = $menu->collection($menuLinks);

                dump($collection->toArray());*/

        /*        $menuItems = $menuItem->query();
                $db        = $menuItems->updateOrCreate(
                    ['group_id' => 1],
                    ['name' => 'Dashboard', 'text' => 'Dashboard2']
                )->links()->sync([2,1])->save();

                dump($menuItems->get()->toArray());*/

        /*        $group = $menuGroup->updateOrCreate([
                    'user_group_id' => 1,
                ], [
                    'text'    => 'Default',
                    'default' => TRUE,
                    'visible' => TRUE,
                ]);

                $group->links()->sync([
                    ['link_id' => 8],
                    ['link_id' => 9],
                    ['link_id' => 10],
                    ['link_id' => 11],
                    ['link_id' => 12],
                    ['link_id' => 13],
                    ['link_id' => 14],
                    ['link_id' => 15],
                ]);

                dump($group);*/

        /*        dump(collect($menu->all())->pluck('element', 'id')->all());

                foreach ( MenuManager::make() as $item ) {
                    $item['children'] = $item['submenu'] ?? [];
                    $create           = $menu->updateOrCreate([
                        'name' => $item['name'],
                    ], $item);
                }*/

        /*        $menuPermission->allowed()->attach()->save();
                $get = $menu->permissions();
                dump($menuPermission);*/

        /*        foreach ( MenuManager::make() as $item ) {
                    $create = $menu->updateOrCreate([
                        'name' => $item['name'],
                    ], $item);
                    if ( !empty($item['submenu']) ) {
                        foreach ( $item['submenu'] as $subitem ) {
                            $create->children()->updateOrCreate([
                                'name' => $subitem['name'],
                                'link' => $subitem['link'],
                            ], $subitem);
                        }
                    }
                }*/

        return view('menu::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public
    function create ()
    {
        return view('menu::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Renderable
     */
    public
    function store (Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public
    function show ($id)
    {
        return view('menu::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public
    function edit ($id)
    {
        return view('menu::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Renderable
     */
    public
    function update (Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public
    function destroy ($id)
    {
        //
    }

}
