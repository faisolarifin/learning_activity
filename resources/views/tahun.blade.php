@extends('templates.template')

@section('content')
    <div class="container">
        <div class="row mt-min-4 justify-content-center">
            <div class="col-sm-10 px-3 py-3 rounded-3 shadow bg-white">
                <h5 class="mb-3">Daftar Tahun</h5>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-post">+ Tambah</button>
                <a href="{{ route('tahun.trash.i') }}" class="btn btn-sm btn-secondary">Data Sampah</a>
                <table class='table table-striped table-bordered mt-2'>
                    <thead>
                        <tr>
                            <th width="100px">#</th>
                            <th>Tahun</th>
                            <th>Deskripsi</th>
                            <th width="160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @php($no = 0)
                        @foreach ($tahun as $row)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $row->nm_tahun }}</td>
                                <td>{{ $row->deskripsi }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="{{ $row->id_thn }}">Edit</button>
                                    <button class="btn btn-sm btn-danger hapus" data-id="{{ $row->id_thn }}">Hapus</button>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Tahun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formSimpan">
                    <div class="modal-body">
                        <div class="mb-2">
                            <input type="hidden" id="kode" name="kode">
                            <label for="tahun" class="form-label">Nama Tahun</label>
                            <input type="text" class="form-control" id="tahun" name="tahun"
                                placeholder="Nama Tahun">
                        </div>                        
                        <div class="mb-2">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi"
                                placeholder="Deskripsi">
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
            $('#modal-post .modal-title').text('Tambah Tahun')
            $('#formSimpan').trigger("reset");
            $('#formUpdate').trigger("reset");
        })

        $('body').on('submit', '#formSimpan', function(e) {
            e.preventDefault()
            $.ajax({
                url: "{{ route('tahun.s') }}",
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
                url: "{{ route('tahun.u') }}",
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
                    url: "{{ route('tahun.d') }}",
                    type: "DELETE",
                    dataType: 'json',
                    data: { kode: _id },
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
            $('#modal-post .modal-title').text('Edit Tahun')

            var url = "{{ route('tahun.r', ':id') }}"; 
            url = url.replace(':id', _id);

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(res) {
                    $('#kode').val(res.id_thn)
                    $('#tahun').val(res.nm_tahun)
                    $('#deskripsi').val(res.deskripsi)
                },
            });
        })

        function showData() {
            $.ajax({
                url: "{{ route('tahun.r') }}",
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    dom = '';
                    $.each(data, function(index, row) {
                        dom += `<tr>
                                <td>${++index}</td>
                                <td>${row.nm_tahun}</td>
                                <td>${row.deskripsi}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="${row.id_thn}">Edit</button>
                                    <button class="btn btn-sm btn-danger hapus" data-id="${row.id_thn}">Hapus</button>
                                </td>
                            </tr>`;
                    })

                    $('#content').html(dom);
                },
            });
        }
    </script>
@endsection
