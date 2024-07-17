<?php

namespace Webkul\DownloadLinks\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'catalog.product.update.after' => [
            'Webkul\DownloadLinks\Listeners\ProductUpdateAfterListener',
        ],
    ];
}
