<?php declare(strict_types=1); 

namespace Webkul\WriteProgram\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Notification\Models\NotificationProxy;
use Webkul\WriteProgram\Contracts\WriteProgram as WriteProgramContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Webkul\WriteProgram\Models\WriteProgramFile;
use Webkul\WriteProgram\Models\WpSubscription;

class WriteProgram extends Model implements WriteProgramContract
{
    public const STATUS_FILE_CREATED = 'file_created';
    public const STATUS_FILE_COMPLETED = 'file_completed';

    protected $fillable = [
        'status',
        'model',
        'brand',
        'vin',
        'capacity',
        'year',
        'service_request',
        'dtc_code',
        'wp_subscriptions_id'
    ];

    protected $statusLabel = [
        self::STATUS_FILE_CREATED => 'File Created',
        self::STATUS_FILE_COMPLETED => 'File Completed',
    ];

    public function subscription()
    {
        return $this->belongsTo(
            WpSubscription::class,
            'wp_subscriptions_id'
        );
    }
    public function files()
    {
        return $this->hasMany(
            WriteProgramFileProxy::modelClass(),
            'write_program_id',
            'id'
        )->latest();
    }

    protected function billing(): Attribute
    {
        return Attribute::make(get: fn () => $this->subscription->plan
        );
    }

    public function notifications()
    {
        return $this->morphMany(NotificationProxy::modelClass(), 'notifiable');
    }

}
