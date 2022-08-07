@extends('templates.template')

@section('content')
    <div class="container">
        <div class="row mt-min-4 justify-content-center">
            <div class="col-sm-10 px-3 py-3 rounded-3 shadow bg-white">
                <h5 class="mb-3">Daftar Bulan</h5>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-post">+ Tambah</button>
                <a href="{{ route('bulan.trash.i') }}" class="btn btn-sm btn-secondary">Data Sampah</a>
                <table class='table table-striped table-bordered mt-2'>
                    <thead>
                        <tr>
                            <th width="100px">#</th>
                            <th>Bulan</th>
                            <th width="160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @php($no = 0)
                        @foreach ($bulan as $row)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $row->nm_bulan }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="{{ $row->id_bln }}">Edit</button>
                                    <button class="btn btn-sm btn-danger hapus" data-id="{{ $row->id_bln }}">Hapus</button>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Bulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formSimpan">
                    <div class="modal-body">
                        <div class="mb-2">
                            <input type="hidden" id="kode" name="kode">
                            <label for="bulan" class="form-label">Nama Bulan</label>
                            <input type="text" class="form-control" id="bulan" name="bulan"
                                placeholder="Nama Bulan">
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
                url: "{{ route('bulan.s') }}",
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
                url: "{{ route('bulan.u') }}",
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
                    url: "{{ route('bulan.d') }}",
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
            $('#modal-post .modal-title').text('Edit Bulan')

            var url = "{{ route('bulan.r', ':id') }}"; 
            url = url.replace(':id', _id);

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(res) {
                    $('#kode').val(res.id_bln)
                    $('#bulan').val(res.nm_bulan)
                },
            });
        })

        function showData() {
            $.ajax({
                url: "{{ route('bulan.r') }}",
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    dom = '';
                    $.each(data, function(index, row) {
                        dom += `<tr>
                                <td>${++index}</td>
                                <td>${row.nm_bulan}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="${row.id_bln}">Edit</button>
                                    <button class="btn btn-sm btn-danger hapus" data-id="${row.id_bln}">Hapus</button>
                                </td>
                            </tr>`;
                    })

                    $('#content').html(dom);
                },
            });
        }
    </script>
@endsection
