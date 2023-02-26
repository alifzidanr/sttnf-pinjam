@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <body>
                        <h2>Selamat datang !</h2>
                        <p>Untuk meminjam ruangan, Anda harus mengikuti tahapan sebagai berikut :</p>
                        <ol>
                          <li>Buka menu ‘Cari Ruangan’ yang terdapat pada sidebar</li>
                          <li>Pilih waktu mulai dan selesai pinjam. Waktu pinjam tidak boleh kurang dari satu jam dan harus berlangsung pada hari yang sama mulai dari pukul 08.00 sampai dengan maksimal pukul 19.00. <strong>Pastikan Anda sudah menyesuaikan dengan kalender akademik dari BAAK STTNF sebelum menentukan waktu pinjam yang hanya berlaku diluar jam perkuliahan atau kegiatan yang tertera pada kalender akademik.</strong> Peminjaman diluar waktu tersebut kemungkinan besar akan ditolak oleh admin.</li>
                          <li>Setelah menginput waktu mulai dan selesai, silakan klik tombol ‘Cari’ untuk menampilkan ruangan yang tersedia berdasarkan waktu yang diatur. Lalu klik tombol ‘Pinjam’ untuk menampilkan form peminjaman ruangan yang meminta Anda untuk menjelaskan keperluan peminjaman dan sarana lain yang diperlukan.</li>
                          <li>Klik submit setelah mengisi form tersebut, dan tunggu notifikasi melalui email untuk memeriksa kembali permintaan Anda pada menu ‘Jadwal’. Jika status permintaan Anda sudah ‘Diterima’, maka Anda dapat membuka menu ‘Detail Jadwal’ dengan menekan tombol ‘view’ pada kolom opsi, yang dapat digunakan sebagai bukti peminjaman ruangan yang sah. Anda juga dapat membatalkan permintaan pada menu ‘Detail Jadwal’ setelah mengirim permintaan.</li>
                        </ol>
                      </body>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection