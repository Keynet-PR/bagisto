<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       
        Schema::create('download_purchased', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->string('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('daily_download_bought')->default(0);
            $table->dateTime('one_time_expired')->nullable();
            $table->string('time_limit')->nullable();
            $table->string('service_request')->nullable();
            $table->dateTime('subscribed_at')->nullable();
            $table->dateTime('subscribed_end')->nullable();
            $table->string('subscribed_default')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('download_purchased');
    }
};
