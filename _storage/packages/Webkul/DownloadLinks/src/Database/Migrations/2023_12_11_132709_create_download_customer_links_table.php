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
       
        Schema::create('download_customer_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('download_purchased_id')->unsigned();
            $table->string('model')->nullable();
            $table->string('brand')->nullable();
            $table->string('vin')->nullable();
            $table->string('capacity')->nullable();
            $table->string('year')->nullable();
            $table->string('service_request')->nullable();
            $table->string('dtc_code')->nullable();
            $table->timestamps();
            $table->foreign('download_purchased_id')->references('id')->on('download_purchased')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('download_customer_links');
    }
};
