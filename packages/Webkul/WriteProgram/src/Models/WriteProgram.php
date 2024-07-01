<?php declare(strict_types=1);

namespace Webkul\WriteProgram\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Customer\Models\CustomerProxy;
use Webkul\Notification\Models\NotificationProxy;
use Webkul\WriteProgram\Contracts\WriteProgram as WriteProgramContract;

class WriteProgram extends Model implements WriteProgramContract
{

    protected $fillable = ['customer_id', 'product', 'amount'];

    public function customer()
    {
        return $this->belongsTo(CustomerProxy::class);
    }

    public function notifications()
    {
        return $this->morphMany(NotificationProxy::class, 'notifiable');
    }
}