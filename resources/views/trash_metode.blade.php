@extends('templates.template')

@section('content')
    <div class="container">
        <div class="row mt-min-4 justify-content-center">
            <div class="col-sm-10 px-3 rounded-3 py-3 shadow bg-white">
                <h5 class="mb-3">Trash Metode</h5>
                <div class="row">
                    <div class="col">
                        <a href="{{ route('metode.i') }}" class="btn btn-sm btn-secondary">Data Bulan</a>
                        <a href="{{ route('metode.trash.i') }}" class="btn btn-sm btn-primary">Data Sampah</a>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-sm btn-success restoreall">Restore Semua</button>
                        <button class="btn btn-sm btn-danger deleteall">Kosongkan Sampah</button>
                    </div>
                </div>
                <table class='table table-striped table-bordered mt-2'>
                    <thead>
                        <tr>
                            <th width="100px">#</th>
                            <th>Tahun</th>
                            <th>Nama Metode</th>
                            <th width="250px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @php($no = 0)
                        @foreach ($metode as $row)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $row->tahun->nm_tahun }} | {{ $row->tahun->deskripsi }} </td>
                                <td>{{ $row->nm_metode }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success restore"
                                        data-id="{{ $row->id_mtd }}">Restore</button>
                                    <button class="btn btn-sm btn-danger delete" data-id="{{ $row->id_mtd }}">Hapus
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
                url: "{{ route('metode.trash.res') }}",
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
                url: "{{ route('metode.trash.resll') }}",
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
                    url: "{{ route('metode.trash.d') }}",
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
                    url: "{{ route('metode.trash.dll') }}",
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
                url: "{{ route('metode.trash.r') }}",
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    dom = '';
                    $.each(data, function(index, row) {
                        dom += `<tr>
                                <td>${++index}</td>
                                <td>${row.tahun.nm_tahun} | ${row.tahun.deskripsi}</td>
                                <td>${row.nm_metode}</td>
                                <td>
                                    <button class="btn btn-sm btn-success restore" data-id="${row.id_mtd}">Restore</button>
                                    <button class="btn btn-sm btn-danger delete" data-id="${row.id_mtd}">Hapus Permanen</button>
                                </td>
                            </tr>`;
                    })

                    $('#content').html(dom);
                },
            });
        }
    </script>
@endsection
