<?php

namespace Webkul\WriteProgram\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\WriteProgram\Models\WpPlan::class,
        \Webkul\WriteProgram\Models\WpSubscription::class,
        \Webkul\WriteProgram\Models\WriteProgram::class,
        \Webkul\WriteProgram\Models\WriteProgramFile::class,
    ];
}