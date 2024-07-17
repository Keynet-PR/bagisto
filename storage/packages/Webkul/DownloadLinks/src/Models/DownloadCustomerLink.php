<?php declare(strict_types=1); 

namespace Webkul\DownloadLinks\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\DownloadLinks\Contracts\DownloadCustomerLink as DownloadCustomerLinkContract;

class DownloadCustomerLink extends Model implements DownloadCustomerLinkContract
{
    protected $table = 'download_customer_links';


    protected $fillable = [
        'download_purchased_id',
        'model',
        'brand',
        'vin',
        'capacity',
        'year',
        'service_request',
        'dtc_code'
    ];

 
    public function links()
    {
        return $this->hasMany(DownloadPurchasedLink::class, 'download_customer_link_id', 'id')->latest();
    }

    public function purchased()
    {
        return $this->belongsTo(DownloadPurchased::class, 'download_purchased_id', 'id');
    }

    
}
