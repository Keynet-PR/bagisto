<?php declare(strict_types=1); 

namespace Webkul\WriteProgram\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Webkul\Customer\Models\CustomerProxy;
use Webkul\User\Models\AdminProxy;
use Webkul\WriteProgram\Contracts\WriteProgramFile as WriteProgramFileContract;

class WriteProgramFile extends Model implements WriteProgramFileContract
{
    protected $table = "write_program_files";

    protected $fillable = [
        'url',
        'file',
        'file_name',
        'file_size',
        'action',
        'write_program_files',
        'customer_id',
        'admin_id',
        'write_program_id'
    ];

    public function customer()
    {
        return $this->belongsTo(
            CustomerProxy::modelClass(),
            'customer_id',
            'id'
        );
    }

    public function technician()
    {
        return $this->belongsTo(
            AdminProxy::modelClass(),
            'admin_id',
            'id'
        );
    }
    protected function fileSize(): Attribute
    {
        return Attribute::make(get: fn () => round((float) $this->attributes['file_size'], 2) . 'KB');
    }

    protected function createdBy(): Attribute
    {
        return Attribute::make(get: fn () => $this->attributes['admin_id']
            ? $this->technician->name
            : $this->customer->first_name . ' ' . $this->customer->last_name);
    }
}
