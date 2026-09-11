<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adiciona "Labeling" no menu, embaixo de "General", visível pros grupos 1 e 4.
 */
class AddLabelingMenuLink extends Migration
{
    private $groups = [1, 4];

    public function up()
    {
        if (!Schema::hasTable('menu_links') || !Schema::hasTable('menu_link_groups')) {
            return;
        }

        $parent = DB::table('menu_links')
            ->whereNull('link_id')
            ->where('title', 'General')
            ->first();

        if (!$parent) {
            // sem o pai "General" não dá pra pendurar — deixa pro usuário criar em /menu
            return;
        }

        $exists = DB::table('menu_links')
            ->where('link_id', $parent->id)
            ->where('title', 'Labeling')
            ->first();

        if (!$exists) {
            $order = (int) DB::table('menu_links')->where('link_id', $parent->id)->max('order') + 1;

            $linkId = DB::table('menu_links')->insertGetId([
                'link_id' => $parent->id,
                'title' => 'Labeling',
                'icon' => 'bx bx-purchase-tag',
                'url' => 'gdrive/labeling',
                'open' => '_self',
                'options' => null,
                'order' => $order,
                'visible' => 'Y',
                'active' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $linkId = $exists->id;
            $order = $exists->order;
        }

        foreach ($this->groups as $groupId) {
            $has = DB::table('menu_link_groups')
                ->where('group_id', $groupId)
                ->where('link_id', $linkId)
                ->exists();

            if (!$has) {
                DB::table('menu_link_groups')->insert([
                    'group_id' => $groupId,
                    'link_id' => $linkId,
                    'model_type' => null,
                    'model_id' => null,
                    'order' => $order,
                    'visible' => 'Y',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        if (!Schema::hasTable('menu_links')) {
            return;
        }

        $link = DB::table('menu_links')->where('title', 'Labeling')->where('url', 'gdrive/labeling')->first();
        if ($link) {
            DB::table('menu_link_groups')->where('link_id', $link->id)->delete();
            DB::table('menu_links')->where('id', $link->id)->delete();
        }
    }
}
