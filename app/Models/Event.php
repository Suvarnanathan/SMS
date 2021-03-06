<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'event_category',
        'event_name'
        ];

        public function users()
        {
            return $this->belongsToMany(User::class)->withTimestamps();
        }
}
