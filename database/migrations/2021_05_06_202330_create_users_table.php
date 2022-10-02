<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->text('username');
            $table->string('mobile_no')->nullable();
            $table->text('password');
            $table->text('email');
            $table->text('nid_no')->nullable();
            $table->text('nid_path')->nullable();
            $table->enum('role', ['user', 'admin']);
            $table->tinyInteger('is_verified')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
