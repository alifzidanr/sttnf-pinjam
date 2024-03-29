<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use \DateTimeInterface;

class Event extends Model
{

    public $table = 'events';

    protected $dates = [
        'end_time',
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'approve',
        'deny',
        'room_id',
        'user_id',
        'usercontact',
        'capacity',
        'end_time',
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'status',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');

    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }


    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;

    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;

    }

    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;

    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;

    }
}
