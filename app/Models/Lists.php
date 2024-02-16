<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
   
    use HasFactory;
    use SoftDeletes;

    protected $table = 'lists';
    protected $fillable = ['listname', 'description'];

    public function subscribers()
    {
        return $this->belongsToMany(Subscribers::class, 'list_subscribers', 'list_id', 'subscriber_id')
            ->withPivot('bouncecount')
            ->withTimestamps();
    }
}
