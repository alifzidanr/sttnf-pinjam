<?php

namespace App\Services;

use App\Event;
use App\Room;
use Carbon\Carbon;

class EventService
{
    public function createRecurringEvents($requestData)
    {
        // $recurringUntil            = Carbon::parse($requestData['recurring_until'])->setTime(23, 59, 59);
        $requestData['start_time'] = Carbon::parse($requestData['start_time'])->addWeek();
        $requestData['end_time']   = Carbon::parse($requestData['end_time'])->addWeek();

        while ($requestData['end_time']->lte($recurringUntil)) {
            $this->createEvent($requestData);
            $requestData['start_time']->addWeek();
            $requestData['end_time']->addWeek();
        }
    }

    public function createEvent($requestData)
    {
        $requestData['start_time'] = $requestData['start_time']->format('Y-m-d H:i');
        $requestData['end_time']   = $requestData['end_time']->format('Y-m-d H:i');

        return Event::create($requestData);
    }

    public function isRoomTaken($requestData)
    {
        $start_time = Carbon::parse($requestData['start_time']);
        $end_time = Carbon::parse($requestData['end_time']);
        
        $events = Event::where('room_id', $requestData['room_id'])
                       ->where('status', 'Diterima')
                       ->where(function ($query) use ($start_time, $end_time) {
                            // Check for overlapping events
                            $query->whereBetween('start_time', [$start_time, $end_time])
                                  ->orWhereBetween('end_time', [$start_time, $end_time])
                                  ->orWhere(function ($query) use ($start_time, $end_time) {
                                        // Check if event is within the time range
                                        $query->where('start_time', '<=', $start_time)
                                              ->where('end_time', '>=', $end_time);
                                   });
                        })
                       ->get();
                       
        return $events->isNotEmpty();
    }
    


    // public function isRoomTaken($requestData)
    // {
    //     // $recurringUntil = Carbon::parse($requestData['recurring_until'])->setTime(23, 59, 59);
    //     $start_time     = Carbon::parse($requestData['start_time']);
    //     $end_time       = Carbon::parse($requestData['end_time']);
    //     $events         = Event::where('room_id', $requestData['room_id'])->get();

    // }
}
