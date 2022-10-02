<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('s_m_s_schedules')->onDelete('cascade');
            $table->text('campaign_id');
            $table->string('app_id');
            $table->integer('conversions')->default(0);
            $table->integer('sent')->default(0);
            $table->integer('delivered')->default(0);
            $table->integer('parked')->default(0);
            $table->enum('status',['CREATED','RUNNING','PAUSED','ENDED'])->default('CREATED');
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
        Schema::dropIfExists('campaigns');
    }
}
