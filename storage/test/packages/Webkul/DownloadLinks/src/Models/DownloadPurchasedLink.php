<?php

namespace Webkul\DownloadLinks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Customer\Models\Customer;
use Webkul\User\Models\Admin;
use Webkul\DownloadLinks\Contracts\DownloadCustomerLink as DownloadCustomerLinkContract;


class DownloadPurchasedLink extends Model implements DownloadCustomerLinkContract
{
    protected $table = 'download_purchased_links';
    
    protected $fillable = [
        'download_customer_link_id',
        'customer_id',
        'admin_id',
        'url',
        'file',
        'file_name'
    ];
    protected $appends = ['created_by'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function technician()
    {
        return $this->hasOne(Admin::class, 'id', 'admin_id');
    }


    public function getCreatedByAttribute()
    {
        return $this->attributes['admin_id'] 
            ? $this->technician->name
            : $this->customer->first_name . ' '. $this->customer->last_name;
    }
}
