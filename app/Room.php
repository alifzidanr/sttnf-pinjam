<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Notifications\Notifiable;

class Room extends Model
{
    use SoftDeletes, Notifiable;

    public $table = 'rooms';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'capacity',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'location',
        'resp',
        'resp_no',
        'email',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
