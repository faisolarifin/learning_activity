@extends('templates.template')

@section('content')
    <div class="container">
        <div class="row px-2 py-3 shadow bg-white mt-min-4 justify-content-center">
            <div class="col-sm-12">
                <div class="row">
                    <h5 class="mb-3">Kelola Jadwal</h5>
                    <div class="col">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-post">+
                            Tambah</button>
                        <a href="{{ route('activity.trash.i') }}" class="btn btn-sm btn-secondary">Data Sampah</a>
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
                            <th>#</th>
                            <th>Metode</th>
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
                                <td>{{ $row->bulan->nm_bulan }}</td>
                                <td>{{ $row->acara }}</td>
                                <td>{{ Date::tgl($row->tgl_awal) }}</td>
                                <td>{{ Date::tgl($row->tgl_akhir) }}</td>
                                <td>{{ $row->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="{{ $row->id_akt }}">Edit</button>
                                    <button class="btn btn-sm btn-danger hapus"
                                        data-id="{{ $row->id_akt }}">Hapus</button>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Aktivitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formSimpan">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col">
                                <label for="tahun" class="form-label">Tahun: </label>
                                <select id="tahun" class="form-select" name="tahun">
                                    @foreach ($tahun as $row)
                                        <option value="{{ $row->id_thn }}">{{ $row->nm_tahun }} | {{ $row->deskripsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <input type="hidden" id="kode" name="kode">
                                <label for="metode" class="form-label">Metode</label>
                                <select class="form-select" name="metode" id="metode">
                                    @foreach ($metode as $row)
                                        <option value="{{ $row->id_mtd }}">{{ $row->nm_metode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="bulan" class="form-label">Bulan</label>
                                <select class="form-select" name="bulan" id="bulan">
                                    @foreach ($bulan as $row)
                                        <option value="{{ $row->id_bln }}">{{ $row->nm_bulan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="status" class="form-label">Status Kegiatan</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="Akan Datang">Akan Datang</option>
                                    <option value="Berlangsung">Berlangsung</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="acara" class="form-label">Acara</label>
                                <input type="text" class="form-control" id="acara" name="acara"
                                    placeholder="Acara">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="tgl_awal" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tgl_awal" name="tgl_awal"
                                    placeholder="Tanggal Mulai">
                            </div>
                            <div class="col">
                                <label for="tgl_akhir" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir"
                                    placeholder="Tanggal Selesai">
                            </div>
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
            $('#modal-post .modal-title').text('Tambah Aktivitas')
            $('#formSimpan').trigger("reset");
            $('#formUpdate').trigger("reset");
        })

        $('body').on('submit', '#formSimpan', function(e) {
            e.preventDefault()
            $.ajax({
                url: "{{ route('activity.s') }}",
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
                url: "{{ route('activity.u') }}",
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
                    url: "{{ route('activity.d') }}",
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
            $('#modal-post .modal-title').text('Edit Aktivitas')

            var url = "{{ route('activity.r', ':id') }}";
            url = url.replace(':id', _id);

            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                success: function(res) {
                    $('#kode').val(res.id_akt)
                    $('#tahun').val(res.id_thn).trigger('change', [res.id_mtd])
                    $('#bulan').val(res.id_bln)
                    $('#acara').val(res.acara)
                    $('#tgl_awal').val(res.tgl_awal)
                    $('#tgl_akhir').val(res.tgl_akhir)
                    $('#status').val(res.status)
                },
            });
        })

        function showData() {
            $.ajax({
                url: "{{ route('activity.r') }}",
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
                                <td>${row.metode.nm_metode}</td>
                                <td>${row.bulan.nm_bulan}</td>
                                <td>${row.acara}</td>
                                <td>${date(row.tgl_awal)}</td>
                                <td>${date(row.tgl_akhir)}</td>
                                <td>${row.status}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="${row.id_akt}">Edit</button>
                                    <button class="btn btn-sm btn-danger hapus" data-id="${row.id_akt}">Hapus</button>
                                </td>
                            </tr>`;
                    })

                    $('#content').html(dom);
                },
            });
        }

        $('#tahun').on('change', function(e, data) {
            $.ajax({
                url: "{{ route('metode.r') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    tahun: $(this).val()
                },
                success: function(res) {
                    dom = '';
                    $.each(res, function(index, row) {
                        dom += `<option value="${row.id_mtd}">${row.nm_metode}</option>`;
                    })
                    $('#metode').html(dom).val(data);
                },
            });

        })

        $('body').on('change', '#thn', function() {
            showData()
        })
    </script>
@endsection
