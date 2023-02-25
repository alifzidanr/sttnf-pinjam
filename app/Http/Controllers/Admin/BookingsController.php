<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Room;
use App\User;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\EventsController;
use App\Http\Requests\SendEmailRequest;
use App\Notifications\EventNotification;
use Illuminate\Notifications\Notifiable;
use Notification;

class BookingsController extends Controller
{

    public function searchRoom(Request $request)
{
    $rooms = null;
    $errorMessage = null;
    $startTime = Carbon::parse($request->input('start_time'));
    $endTime = Carbon::parse($request->input('end_time'));

    if($request->filled(['start_time', 'end_time', 'capacity']) && $startTime->between($startTime->copy()->startOfDay()->addHours(8), $startTime->copy()->startOfDay()->addHours(19)) && $endTime->between($endTime->copy()->startOfDay()->addHours(8), $endTime->copy()->startOfDay()->addHours(19))) {

        if ($startTime > $endTime) {
            $errorMessage = "Waktu mulai tidak bisa lebih maju daripada waktu selesai";
        } elseif ($startTime->diffInDays($endTime) > 0) {
            $errorMessage = "Waktu mulai dan selesai harus pada hari yang sama";
        } elseif ($startTime->diffInMinutes($endTime) < 60) {
            $errorMessage = "Minimal waktu peminjaman ruangan adalah satu jam";
        } else {
            $times = [
                $startTime,
                $endTime,
            ];

            $rooms = Room::where('capacity', '>=', $request->input('capacity'))
                ->whereDoesntHave('events', function ($query) use ($times) {
                    $query->where('status', 'Diterima')
                        ->where(function ($query) use ($times) {
                            $query->whereBetween('start_time', $times)
                                ->orWhereBetween('end_time', $times)
                                ->orWhere(function ($query) use ($times) {
                                    $query->where('start_time', '<', $times[0])
                                        ->where('end_time', '>', $times[1]);
                                });
                        });
                })
                ->get();
        }
    } else {
        $errorMessage = "Waktu pinjam ruangan adalah pukul 08.00-19.00 dihari yang sama";
    }

    return view('admin.bookings.search', compact('rooms', 'errorMessage'));
}

    // public function searchRoom(Request $request)
    // {
    //     $rooms = null;
    //     $errorMessage = null;
    //     $startTime = Carbon::parse($request->input('start_time'));
    //     $endTime = Carbon::parse($request->input('end_time'));
    
    //     if($request->filled(['start_time', 'end_time', 'capacity']) && $startTime->between($startTime->copy()->startOfDay()->addHours(8), $startTime->copy()->startOfDay()->addHours(19)) && $endTime->between($endTime->copy()->startOfDay()->addHours(8), $endTime->copy()->startOfDay()->addHours(19))) {
    
    //         if ($startTime > $endTime) {
    //             $errorMessage = "Waktu mulai tidak bisa lebih maju daripada waktu selesai";
    //         } elseif ($startTime->diffInDays($endTime) > 0) {
    //             $errorMessage = "Waktu mulai dan selesai harus pada hari yang sama";
    //         } else {
    //             $times = [
    //                 $startTime,
    //                 $endTime,
    //             ];
    
    //             $rooms = Room::where('capacity', '>=', $request->input('capacity'))
    //                 ->whereDoesntHave('events', function ($query) use ($times) {
    //                     $query->where('status', 'Diterima')
    //                         ->where(function ($query) use ($times) {
    //                             $query->whereBetween('start_time', $times)
    //                                 ->orWhereBetween('end_time', $times)
    //                                 ->orWhere(function ($query) use ($times) {
    //                                     $query->where('start_time', '<', $times[0])
    //                                         ->where('end_time', '>', $times[1]);
    //                                 });
    //                         });
    //                 })
    //                 ->get();
    //         }
    //     } else {
    //         $errorMessage = "Waktu pinjam ruangan adalah 08.00-19.00 dihari yang sama";
    //     }
    
    //     return view('admin.bookings.search', compact('rooms', 'errorMessage'));
    // }
    




    public function bookRoom(Request $request, EventService $eventService)
    {
        $request->merge([
            'user_id' => auth()->id()
        ]);

        $request->validate([
            'title'   => 'required',
            'room_id' => 'required',
        ]);

        $room = Room::findOrFail($request->input('room_id'));
        

        if ($eventService->isRoomTaken($request->all())) {
            return redirect()->back()
                    ->withInput()
                    ->withErrors(['recurring_until' => 'This room is not available until the recurring date you have chosen']);
        }

        $event = Event::create($request->all());

        if ($request->filled('recurring_until')) {
            $eventService->createRecurringEvents($request->all());
        }


        $ruangan = Room::find($event);
        $EmailMessage = [
            'body'      => 'Ada permintaan baru yang masuk. Silakan cek status permintaan yang masuk dengan mengklik tombol berikut :',
            'isi_pesan' => 'Cek Jadwal',
            'url'       => url('/'),
            'penutup'  => 'Anda dapat menerima atau menolak permintaan tersebut. Terimakasih',
        ];
    
        Notification::send  ($ruangan, new EventNotification($EmailMessage));

        return redirect()->route('admin.systemCalendar')->withStatus('Ruangan berhasil dipinjam');
    }
}
