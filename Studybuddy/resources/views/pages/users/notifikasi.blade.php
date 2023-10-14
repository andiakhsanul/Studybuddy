@extends('Layout.appUser')

@section('content')
<div class="row pt-4">
    <div class="col">
        <div class="card mb-3">
            <div class="card-header text-center bg-primary">
                <h4 class="text-white">Notifikasi {{ $namaUser }}</h4>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped border border-white">
        <thead>
            <tr>
                <th class="bg-primary text-white border-bottom">Notifikasi</th>
                <th class="bg-primary text-white">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengingat as $item)
            <tr>
                <td class="bg-light text-dark border-bottom">
                    @if($item->skala_prioritas == 1)
                        <span class="text-danger">Tugas Penting:</span>
                    @else
                        <span class="text-success">Tugas Sampingan:</span>
                    @endif
                    {{ $item->waktuSisa }}
                </td>
                <td class="bg-light text-dark">
                    <strong>{{ $item->judulCatatan }}</strong><br>
                    {{ $item->keterangan }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center">Belum ada notifikasi yang masuk</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


{{-- Versi Statiknya --}}
<div class="row pt-4">
    <div class="col">
        <div class="card mb-3">
            <div class="card-header text-center bg-primary">
                <h4 class="text-white">Notifikasi {{ $namaUser }}</h4>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped border border-white">
        <thead>
            <tr>
                <th class="bg-primary text-white border-bottom">Notifikasi</th>
                <th class="bg-primary text-white">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="bg-light text-dark border-bottom">
                    <span class="text-danger">Tugas Penting: 30 Menit</span> Waktu Sisa
                </td>
                <td class="bg-light text-dark">
                    <strong class="text-primary">Judul Catatan : UTS Semester 3</strong><br>
                    Keterangan : Projek Laravel Workshop
                </td>
            </tr>
            <tr>
                <td class="bg-light text-dark border-bottom">
                    <span class="text-success">Tugas Sampingan: 5 Menit</span> Waktu Sisa
                </td>
                <td class="bg-light text-dark">
                    <strong class="text-primary">Judul Catatan : Event Musik</strong><br>
                    Keterangan : Latihan Nyanyi
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center text-primary"><b>Belum ada notifikasi yang masuk</b></td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
