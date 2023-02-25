<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Room;
use App\Services\EventService;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Notifications\EventNotification;
use Notification;
use App\Http\Requests\SendEmailRequest;


class EventsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::all();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.events.create', compact('rooms', 'users'));
    }

    public function store(StoreEventRequest $request, EventService $eventService)
    {
        if ($eventService->isRoomTaken($request->all())) {
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors('Ruangan tidak tersedia dengan waktu yang ditentukan');
        }

        $event = Event::create($request->all());

        if ($request->filled('recurring_until')) {
            $eventService->createRecurringEvents($request->all());
        }

        return redirect()->route('admin.events.index');

    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $event->load('room', 'user');

        return view('admin.events.edit', compact('rooms', 'users', 'event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->all());

        return redirect()->route('admin.events.index');

    }

    public function show(Event $event)
    {
        abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->load('room', 'user');

        return view('admin.events.show', compact('event'));
    }

    public function showpdf(Event $event)
    {
        // abort_if(Gate::denies('event_showpdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $event->load('room', 'user');
       
        return view('admin.events.showpdf', compact('event'));
    }

    
    public function destroy(Event $event)
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->delete();

        return back();

    }


    public function massDestroy(MassDestroyEventRequest $request)
    {
        Event::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }

    public function accept($id){
        abort_if(Gate::denies('event_accept'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $event=Event::find($id);
        $event->status='Diterima';
        $event->save();

        if ($event->save()) {
            return redirect()->route('sendEmail', $event->user->id);
        }

        return redirect()->back();
    }

    public function deny($id){
        abort_if(Gate::denies('event_deny'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event=Event::find($id);
        $event->status='Ditolak';
        $event->save();

        if ($event->save()) {
            return redirect()->route('sendEmail', $event->user->id);
        }

        return redirect()->back();
    }

    public function sendEmail($id)
    {
        abort_if(Gate::denies('event_accept'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::find($id);

        $EmailMessage = [
            'body'      => 'Permintaan Anda telah kami beri respon. Silakan cek status permintaan Anda dengan mengklik tombol berikut :',
            'isi_pesan' => 'Cek Jadwal',
            'url'       => url('/'),
            'penutup'  => 'Jika ada pertanyaan atau keluhan, silakan hubungi nomor kontak penanggung jawab ruangan yang bersangkutan. Terimakasih',
        ];
    
        Notification::send  ($users, new EventNotification($EmailMessage));

        return redirect()->back();
    }

    public function cancelOrder($id){
        abort_if(Gate::denies('event_cancel'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event=Event::find($id);
        $event->delete();
        return redirect()->route('admin.events.index');
    }

}

    


