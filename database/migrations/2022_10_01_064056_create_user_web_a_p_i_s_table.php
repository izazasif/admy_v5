<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWebAPISTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_web_a_p_i_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('web_api_id')->constrained('web_apis')->onDelete('cascade');
            $table->enum('payment_status',['Pending','Paid'])->default('Pending');
            $table->unsignedInteger('acquisition')->default(0);
            $table->unsignedFloat('price')->default(0);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('user_web_a_p_i_s');
    }
}
