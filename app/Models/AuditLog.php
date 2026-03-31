<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'event_type',
        'user_id',
        'ip_address_id',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
