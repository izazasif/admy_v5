<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_web_api_id');
            $table->string('payment_id');
            $table->string('trxID')->nullable();
            $table->string('transactionStatus')->default('Initiated');
            $table->string('amount')->default(0);
            $table->string('intent')->default('sale');
            $table->string('merchantInvoiceNumber');
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
        Schema::dropIfExists('web_payment_histories');
    }
}
