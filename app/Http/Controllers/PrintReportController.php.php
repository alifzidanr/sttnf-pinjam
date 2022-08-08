<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EventService;
use App\Event;
use App\User;
use App\Room;

class PrintReportController extends Controller
{
    //

    public function printpdf(Event $event)
    {
        $event = Event::all();
 
        $ppdf = PDF::loadview('pegawai_pdf',['pegawai'=>$pegawai]);
        return $pdf->download('laporan-pegawai-pdf');

    }
}
