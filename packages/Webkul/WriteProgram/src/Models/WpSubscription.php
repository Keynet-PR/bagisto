<?php declare(strict_types=1);

namespace Webkul\WriteProgram\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Webkul\WriteProgram\Models\WpPlan;
use Illuminate\Database\Eloquent\Model;
use Webkul\Customer\Models\CustomerProxy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Webkul\WriteProgram\Models\WriteProgramProxy;
use Webkul\WriteProgram\Contracts\WpSubscription as WpSubscriptionContract;

class WpSubscription extends Model implements WpSubscriptionContract
{
    protected $table = "wp_subscriptions";
    
    public $timestamps = false;

    protected $fillable = [
        'start_at',
        'end_at',
        'customer_id',
        'subscribed_as',
        'wp_plan_id'
    ];

    protected $casts = [
        'start_at' => 'date:Y-m-d',
        'end_at' => 'date:Y-m-d',
    ];

    public function plan()
    {
        return $this->belongsTo(
            WpPlan::class,
            'wp_plan_id',
            'id'
        );
    }

    public function customer()
    {
        return $this->belongsTo(
            CustomerProxy::modelClass(),
            'customer_id',
            'id'
        );
    }

    public function writables()
    {
        return $this->hasMany(
            WriteProgramProxy::modelClass(),
            'wp_subscriptions_id',
            'id'
        );
    }

    public function isExpire(): bool
    {
        return $this->end_at < now();
    }

    protected function dailyDownloadUsed(): Attribute
    {
       return Attribute::make(
            get: fn() => $this->loadCount(['writables' => fn($q) => $q->whereDate('created_at', Carbon::today())])->writables_count
        );
    }
    
    protected function subscribedAt(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->attributes['start_at'])->format('Y/m/d') . '-' . Carbon::parse($this->attributes['end_at'])->format('Y/m/d')

        );
    }
    
    protected function status(): Attribute
    {
        return Attribute::make(get: fn () => 
            $this->plan->daily_download_bought  <= $this->daily_download_used || $this->isExpire()
                ? 'Un Available'
                : 'Available');
    }
    
    public function allowUploadLimit(): bool
    {
        return $this->plan->daily_download_bought <= $this->daily_download_used;
    }


}
