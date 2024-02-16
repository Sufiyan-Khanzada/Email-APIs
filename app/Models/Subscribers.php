<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscribers extends Model
{
    use HasFactory;
   // use SoftDeletes;
    
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'isp',
        'optin_date',
        'ip_address',
        'referring_url',
        'vertical',
        'country',
        'state',
        'zip_code',
        'city',
        'device',
    ];

    public function lists()
    {
        return $this->belongsToMany(Lists::class, 'list_subscribers', 'subscriber_id', 'list_id')
            ->withPivot('bouncecount')
            ->withTimestamps();
    }
}