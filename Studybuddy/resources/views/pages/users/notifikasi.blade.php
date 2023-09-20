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
                <th class="bg-primary text-white border-bottom">Tanggal Pengingat</th>
                <th class="bg-primary text-white">Judul Catatan</th>
                <th class="bg-primary text-white">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengingat as $item)
            <tr>
                <td class="bg-light text-dark border-bottom">{{ $item->TANGGAL_PENGINGAT }}</td>
                <td class="bg-light text-dark">{{ $item->JUDUL_PENGINGAT }}</td>
                <td class="bg-light text-dark">{{ $item->KETERANGAN }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Belum ada Notifikasi yang masuk</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
