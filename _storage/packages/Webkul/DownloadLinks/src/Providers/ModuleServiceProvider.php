<?php

namespace Webkul\DownloadLinks\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\DownloadLinks\Models\DownloadCustomerLink::class,
    ];
}
