<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webkul\WriteProgram\Models\WpPlan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wp_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referent_code')->unique();
            $table->string('name');
            $table->string('service_request');
            $table->integer('daily_download_bought')->default(0);
            $table->integer('daily_download_used')->default(0);
            $table->timestamps();
        });

        $subscriptions = [
            [
                'name' => 'One-time',
                'daily_download_bought' => 1,
                'daily_download_used' => 1,
                'service_request' => 'adblue'
            ],
            [
                'name' => 'Monthly',
                'daily_download_bought' => 3,
                'daily_download_used' => 3,
                'service_request' => 'adblue'
            ],
            [
                'name' => 'Yearly',
                'daily_download_bought' => 5,
                'daily_download_used' => 5,
                'service_request' => 'adblue'
            ],
            [
                'name' => 'One-time',
                'daily_download_bought' => 1,
                'daily_download_used' => 1,
                'service_request' => 'dtc'
            ],
            [
                'name' => 'Monthly',
                'daily_download_bought' => 3,
                'daily_download_used' => 3,
                'service_request' => 'dtc'
            ],
            [
                'name' => 'Yearly',
                'daily_download_bought' => 5,
                'daily_download_used' => 5,
                'service_request' => 'dtc'
            ],
            [
                'name' => 'One-time',
                'daily_download_bought' => 1,
                'daily_download_used' => 1,
                'service_request' => 'dpf'
            ],
            [
                'name' => 'Monthly',
                'daily_download_bought' => 3,
                'daily_download_used' => 3,
                'service_request' => 'dpf'
            ],
            [
                'name' => 'Yearly',
                'daily_download_bought' => 5,
                'daily_download_used' => 5,
                'service_request' => 'dpf'
            ],
            [
                'name' => 'One-time',
                'daily_download_bought' => 1,
                'daily_download_used' => 1,
                'service_request' => 'egr'
            ],
            [
                'name' => 'Monthly',
                'daily_download_bought' => 3,
                'daily_download_used' => 3,
                'service_request' => 'egr'
            ],
            [
                'name' => 'Yearly',
                'daily_download_bought' => 5,
                'daily_download_used' => 5,
                'service_request' => 'egr'
            ]
        ];
        foreach ($subscriptions as $subscription) {
            WpPlan::query()->create($subscription);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wp_plans');
    }
};
