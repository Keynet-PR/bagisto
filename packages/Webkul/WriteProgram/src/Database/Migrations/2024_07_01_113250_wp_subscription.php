<?php declare(strict_types=1); 

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
        Schema::create('wp_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->boolean('subscribed_as')->default(false);
            $table->integer('customer_id')->unsigned();
            $table->integer('wp_plan_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('wp_plan_id')->references('id')->on('wp_plans')->onDelete('cascade');
         
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('wp_subscriptions');
    }
};
