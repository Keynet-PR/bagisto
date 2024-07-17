<?php declare(strict_types=1);

namespace Webkul\DownloadLinks\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\DownloadLinks\Contracts\DownloadCustomerLink as DownloadCustomerLinkContract;

class DownloadPurchased extends Model implements DownloadCustomerLinkContract
{
    protected $table = 'download_purchased';

    protected $fillable = [
        'order_id',
        'customer_id',
        'product_id',
        'product_name',
        'time_limit',
        'service_request',
        'daily_download_bought',
        'one_time_expired',
        'subscribed_at',
        'subscribed_end',
        'subscribed_default'

    ];
    protected $appends = [
        'subscription',
        'daily_download_used',
        'status',
    ];

    protected $casts = [
        'subscribed_at' => 'date:Y-m-d',
        'subscribed_end' => 'date:Y-m-d',
    ];

    public function downloadCustomerLink()
    {
        return $this->hasMany(downloadCustomerLink::class, 'download_purchased_id');
    }
    public function getSubscriptionAttribute(): string
    {
        return Carbon::parse($this->subscribed_at)->format('Y/m/d') . '-' . Carbon::parse($this->subscribed_end)->format('Y/m/d');
    }
    public function isExpire(): bool
    {
        if(!is_null($this->one_time_expired)){
            return true;
        }
        else if($this->subscribed_end < now()){
             return true;
        }
        return false;
    }

    public function getDailyDownloadUsedAttribute(): int
    {
        return $this->downloadCustomerLink()
            ->whereDate('created_at', now()->today())
            ->count();
    }

    public function getStatusAttribute(): string
    {
        return $this->daily_download_bought <= $this->daily_download_used
            ? 'Un Available'
            : 'Available';
    }

    public function isLimitUpload(): bool
    {
        return $this->daily_download_bought <= $this->daily_download_used;
    }

    public function multiSubscribed(): object
    {
        return static::query()
            ->whereDate('subscribed_end', '<', now()->today())
            ->where('service_request', $this->service_request)
            ->get();
    }

    public function isMultiSubscribed(): bool
    {
        return $this->multiSubscribed()->count() > 0;
    }

}
