<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebAPISchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_a_p_i_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('dev_name')->nullable();
            $table->string('dev_email')->nullable();
            $table->string('dev_number')->nullable();
            $table->string('app_id');
            $table->string('app_name');
            $table->string('app_type')->nullable();
            $table->string('deposit_slip')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->datetime('schedule_time');
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
        Schema::dropIfExists('web_a_p_i_schedules');
    }
}
