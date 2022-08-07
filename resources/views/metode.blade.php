@extends('templates.template')

@section('content')
    <div class="container">
        <div class="row mt-min-4 justify-content-center">
            <div class="col-sm-10 px-3 rounded-3 py-3 shadow bg-white">
                <h5 class="mb-3">Daftar Metode</h5>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-post">+
                            Tambah</button>
                        <a href="{{ route('metode.trash.i') }}" class="btn btn-sm btn-secondary">Data Sampah</a>
                    </div>
                    <div class="col-sm-3 d-flex align-items-center justify-content-end">
                        <label for="thn">Tahun: </label>
                        <select id="thn" class="form-select form-select-sm mx-2">
                            @foreach ($tahun as $row)
                                <option value="{{ $row->id_thn }}">{{ $row->nm_tahun }} | {{ $row->deskripsi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table class='table table-striped table-bordered mt-2'>
                    <thead>
                        <tr>
                            <th width="100px">#</th>
                            <th>Nama Metode</th>
                            <th width="160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @php($no = 0)
                        @foreach ($metode as $row)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $row->nm_metode }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="{{ $row->id_mtd }}">Edit</button>
                                    <button class="btn btn-sm btn-danger hapus" data-id="{{ $row->id_mtd }}">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-post" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Metode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formSimpan">
                    <div class="modal-body">
                        <div class="mb-2">
                            <input type="hidden" id="kode" name="kode">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select id="tahun" name="tahun" class="form-select">
                                @foreach ($tahun as $row)
                                    <option value="{{ $row->id_thn }}">{{ $row->nm_tahun }} | {{ $row->deskripsi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="metode" class="form-label">Nama Metode</label>
                            <input type="text" class="form-control" id="metode" name="metode"
                                placeholder="Nama Metode">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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

        $('#modal-post').on('hide.bs.modal', function(e) {
            $('#modal-post form').attr('id', 'formSimpan');
            $('#modal-post .modal-title').text('Tambah Bulan')
            $('#formSimpan').trigger("reset");
            $('#formUpdate').trigger("reset");
        })

        $('body').on('submit', '#formSimpan', function(e) {
            e.preventDefault()
            $.ajax({
                url: "{{ route('metode.s') }}",
                type: "POST",
                dataType: 'json',
                data: $('#formSimpan').serialize(),
                success: function(data) {
                    $('#modal-post').modal('hide');
                    showData();
                },
            });
        });
        $('body').on('submit', '#formUpdate', function(e) {
            e.preventDefault()
            $.ajax({
                url: "{{ route('metode.u') }}",
                type: "PUT",
                dataType: 'json',
                data: $('#formUpdate').serialize(),
                success: function(data) {
                    $('#modal-post').modal('hide');
                    showData();
                },
            });
        });

        $('body').on('click', '.hapus', function(e) {
            var _id = $(this).data('id')
            if (confirm("Data akan pindahkan ke sampah?")) {
                $.ajax({
                    url: "{{ route('metode.d') }}",
                    type: "DELETE",
                    dataType: 'json',
                    data: {
                        kode: _id
                    },
                    success: function(res) {
                        showData();
                    },
                });
            }
        })
        $('body').on('click', '.edit', function(e) {
            var _id = $(this).data('id')
            $('#modal-post').modal('show');
            $('#modal-post form').attr('id', 'formUpdate')
            $('#modal-post .modal-title').text('Edit Metode')

            var url = "{{ route('metode.r', ':id') }}";
            url = url.replace(':id', _id);

            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                success: function(res) {
                    $('#kode').val(res.id_mtd)
                    $('#tahun').val(res.id_thn)
                    $('#metode').val(res.nm_metode)
                },
            });
        })

        function showData() {
            $.ajax({
                url: "{{ route('metode.r') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    tahun: $('#thn').val()
                },
                success: function(data) {
                    dom = '';
                    $.each(data, function(index, row) {
                        dom += `<tr>
                                <td>${++index}</td>
                                <td>${row.nm_metode}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="${row.id_mtd}">Edit</button>
                                    <button class="btn btn-sm btn-danger hapus" data-id="${row.id_mtd}">Hapus</button>
                                </td>
                            </tr>`;
                    })

                    $('#content').html(dom);
                },
            });
        }

        $('body').on('change', '#thn', function() {
            showData()
        })
    </script>
@endsection
