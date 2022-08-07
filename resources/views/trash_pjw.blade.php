@extends('templates.template')

@section('content')
    <div class="container">
        <div class="row px-2 py-3 shadow rounded-3 bg-white mt-min-4 justify-content-center">
            <div class="col-sm-12">
                <h5 class="mb-3">Trash Jadwal</h5>
                <div class="row">
                    <div class="col">
                        <a href="{{ route('activity.i') }}" class="btn btn-sm btn-secondary">Data Kegiatan</a>
                        <a href="{{ route('activity.trash.i') }}" class="btn btn-sm btn-primary">Data Sampah</a>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-sm btn-success restoreall">Restore Semua</button>
                        <button class="btn btn-sm btn-danger deleteall">Kosongkan Sampah</button>
                    </div>
                </div>

                <table class='table table-striped table-bordered mt-2'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Metode</th>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Acara</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @php($no = 0)
                        @foreach ($pjw as $row)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $row->metode->nm_metode }}</td>
                                <td>{{ $row->tahun->nm_tahun }} ({{ $row->tahun->deskripsi }})</td>
                                <td>{{ $row->bulan->nm_bulan }}</td>
                                <td>{{ $row->acara }}</td>
                                <td>{{ Date::tgl($row->tgl_awal) }}</td>
                                <td>{{ Date::tgl($row->tgl_akhir) }}</td>
                                <td>{{ $row->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success restore"
                                        data-id="{{ $row->id_akt }}">Restore</button>
                                    <button class="btn btn-sm btn-danger delete" data-id="{{ $row->id_akt }}">Hapus
                                        Permanen</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })

        $('body').on('click', '.restore', function(e) {
            var _id = $(this).data('id')
            $.ajax({
                url: "{{ route('activity.trash.res') }}",
                type: "POST",
                dataType: 'json',
                data: { kode: _id },
                success: function(res) {
                    showData();
                },
            });
        })
        $('body').on('click', '.restoreall', function(e) {
            var _id = $(this).data('id')
            $.ajax({
                url: "{{ route('activity.trash.resll') }}",
                type: "POST",
                dataType: 'json',
                success: function(res) {
                    showData();
                },
            });
        })
        $('body').on('click', '.delete', function(e) {
            var _id = $(this).data('id')
            if (confirm("Anda akan menghapus data permanen?")) {
                $.ajax({
                    url: "{{ route('activity.trash.d') }}",
                    type: "POST",
                    dataType: 'json',
                    data: { kode: _id },
                    success: function(res) {
                        showData();
                    },
                });
            }
        })
        $('body').on('click', '.deleteall', function(e) {
            if (confirm("Anda akan menghapus semua data permanen?")) {
                $.ajax({
                    url: "{{ route('activity.trash.dll') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(res) {
                        showData();
                    },
                });
            }
        })


        function showData() {
            $.ajax({
                url: "{{ route('activity.trash.r') }}",
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    dom = '';
                    $.each(data, function(index, row) {
                        dom += `<tr>
                                <td>${++index}</td>
                                <td>${row.metode.nm_metode}</td>
                                <td>${row.tahun.deskripsi} (${row.tahun.nm_tahun})</td>
                                <td>${row.bulan.nm_bulan}</td>
                                <td>${row.acara}</td>
                                <td>${date(row.tgl_awal)}</td>
                                <td>${date(row.tgl_akhir)}</td>
                                <td>${row.status}</td>
                                <td>
                                    <button class="btn btn-sm btn-success restore" data-id="${row.id_akt}">Restore</button>
                                    <button class="btn btn-sm btn-danger delete" data-id="${row.id_akt}">Hapus Permanen</button>
                                </td>
                            </tr>`;
                    })

                    $('#content').html(dom);
                },
            });
        }
    </script>
@endsection
