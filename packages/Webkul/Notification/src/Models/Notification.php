<?php declare(strict_types=1); 

namespace Webkul\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Notification\Contracts\Notification as NotificationContract;
use Webkul\Sales\Models\OrderProxy;

class Notification extends Model implements NotificationContract
{
    protected $fillable = [
        'type',
        'read',
        'notifiable_type',
        'notifiable_id',
        'customer_id'
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function notify()
    {
        return $this->belongsTo(
            NotificationTypeProxy::modelClass(),
            'notifiable_id',
            'id'
        );
    }
}
