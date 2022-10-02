<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('sms_category',['bulk','push']);
            $table->enum('sms_type',['Masking','Non-musking']);
            $table->double('price', 8, 2);
            $table->double('unit_price', 8, 2);
            $table->bigInteger('amount');
            $table->integer('validity');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('s_m_s');
    }
}
