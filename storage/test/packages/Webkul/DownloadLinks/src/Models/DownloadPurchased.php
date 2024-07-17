<?php

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
        'daily_download_used',
        'subscribed_at',
        'subscribed_end',
    ];
    protected $appends = [
        'subscription',
        'is_expire'
    ];
    
    protected $casts = [
        'subscribed_at'  => 'date:Y-m-d',
        'subscribed_end'  => 'date:Y-m-d',
    ];


    public function getSubscriptionAttribute()
    {
        return Carbon::parse($this->attributes['subscribed_at'])->format('Y/m/d') .'-' .Carbon::parse( $this->attributes['subscribed_end'])->format('Y/m/d');
    }
    public function getIsExpireAttribute()
    {
        return Carbon::parse( $this->attributes['subscribed_end'])->format('Y-m-d') == now()->today()->format('Y-m-d') ? 1 : 0;
    }
}
