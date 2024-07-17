<?php

namespace Webkul\DownloadLinks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\DownloadLinks\Contracts\DownloadCustomerLink as DownloadCustomerLinkContract;

class DownloadCustomerLink extends Model implements DownloadCustomerLinkContract
{
    protected $table = 'download_customer_links';
    

    protected $fillable = [
        'customer_id',
        'model',
        'brand',
        'vin',
        'capacity',
        'year',
        'service_request',
        'dtc_code'
    ];

    protected $appends = [
        'daily_download_used',
        'status',
    ];

    public function links()
    {
        return $this->hasMany(DownloadPurchasedLink::class, 'download_customer_link_id', 'id')->latest();
    }

    public function purchased()
    {
        return $this->hasOne(DownloadPurchased::class, 'service_request', 'service_request');
          
    }

    public function getDailyDownloadUsedAttribute(){
       return $this->links()->whereDate('created_at', now()->today())->count();
    }

    public function getStatusAttribute()
    {
        return $this->purchased['daily_download_bought'] <= $this->daily_download_used
            ? 'Un Available'
            : 'Available';
    }
}
