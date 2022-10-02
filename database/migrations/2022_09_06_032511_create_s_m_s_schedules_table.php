<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_m_s_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('app_id');
            $table->string('app_name');
            $table->string('ussd_code');
            $table->string('keyword')->nullable();
            $table->text('sms_text')->nullable();
            $table->text('remark')->nullable();
            $table->datetime('schedule_time');
            $table->datetime('actual_delivery_time')->nullable();
            $table->bigInteger('sms_amount');
            $table->boolean('is_content_up_to_date')->default(0);
            $table->boolean('is_app_uat_done')->default(0);
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
        Schema::dropIfExists('s_m_s_schedules');
    }
}
