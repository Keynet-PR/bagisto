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
            $table->string('model');
            $table->string('brand');
            $table->string('year');
            $table->string('vin');
            $table->integer('wp_subscriptions_id')->unsigned();
            $table->foreign('wp_subscriptions_id')->references('id')->on('wp_subscriptions')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('write_programs');
    }
};
