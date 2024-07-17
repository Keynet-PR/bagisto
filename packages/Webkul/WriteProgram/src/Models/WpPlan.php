<?php

namespace Webkul\WriteProgram\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\WriteProgram\Contracts\WpPlan as WpPlanContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class WpPlan extends Model implements WpPlanContract
{
    protected $table = "wp_plans";

    protected $fillable = [
        'referent_code',
        'name',
        'service_request',
        'daily_download_bought',
        'daily_download_used'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->referent_code = static::generateReferentCode();
        });
    }

    protected static function generateReferentCode()
    {
        do {
            $code = Str::random(10); // Adjust length as needed
        } while (static::where('referent_code', $code)->exists());

        return $code;
    }
}
