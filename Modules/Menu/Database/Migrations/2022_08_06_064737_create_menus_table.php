<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration {

    protected $menu = [
        'groups' => 'menu_link_groups',
        'links'  => 'menu_links',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create($this->menu['links'], function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->nullable()->constrained($this->menu['links'])->onDelete('cascade');
            $table->string('title', 100);
            $table->string('icon', 50)->nullable();
            $table->text('url')->nullable();
            $table->enum('open', ['_self', '_blank'])->default('_self');
            $table->json('options')->nullable();
            $table->tinyInteger('order')->default(0);
            $table->enum('visible', ['Y', 'N'])->default('N');
            $table->enum('active', ['Y', 'N'])->default('Y');
            $table->timestamps();
        });

        Schema::create($this->menu['groups'], function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->nullable()->constrained('user_groups')->onDelete('cascade');
            $table->foreignId('link_id')->constrained($this->menu['links'])->onDelete('cascade');
            $table->nullableMorphs('model');
            $table->tinyInteger('order')->default(0);
            $table->enum('visible', ['Y', 'N'])->default('Y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {

        foreach ( $this->menu as $table ) {
            Schema::dropIfExists($table);
        }
    }

}
