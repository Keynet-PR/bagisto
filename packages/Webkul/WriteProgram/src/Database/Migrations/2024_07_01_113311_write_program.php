<?php declare(strict_types=1); 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('write_programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->default('file_created');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('vin')->nullable();
            $table->string('capacity')->nullable();
            $table->string('year')->nullable();
            $table->string('service_request')->nullable();
            $table->string('dtc_code')->nullable();
            $table->timestamps();
            $table->integer('wp_subscriptions_id')->unsigned();
            $table->foreign('wp_subscriptions_id')->references('id')->on('wp_subscriptions')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('write_programs');
    }
};
