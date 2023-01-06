<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePasswordsTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::create('passwords', function ( Blueprint $table ) {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable();
                $table->string('url');
                $table->string('username');
                $table->string('password');
                $table->foreignId('created_by')->nullable()->constrained('users');
                $table->foreignId('updated_by')->nullable()->constrained('users');
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
            Schema::dropIfExists('passwords');
        }

    }
