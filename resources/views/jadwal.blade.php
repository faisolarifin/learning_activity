@extends('templates.template')

@section('content')
    <div class="container">
        <div class="row py-3 shadow bg-white mt-min-4 rounded-3 justify-content-center">
            <div class="col-sm-12">
                <div class="row mb-2">
                    <div class="col">
                        <h5>Learning Activity</h5>
                    </div>
                    <div class="col-sm-3 d-flex align-items-center justify-content-end">
                        <label for="tahun">Tahun: </label>
                        <select id="tahun" class="form-select form-select-sm mx-2 w-50">
                            @foreach ($tahun as $row)
                                <option value="{{ $row->id_thn }}">{{ $row->nm_tahun }} | {{$row->deskripsi}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-5 d-flex align-items-center">
                        <label for="tgl_awal">Bulan: </label>
                        <select id="tgl_awal" class="form-select form-select-sm mx-2">
                            @foreach ($bulan as $row)
                                <option value="{{ $row->id_bln }}">{{ $row->nm_bulan }}</option>
                            @endforeach
                        </select>
                        <label for="tgl_akhir">-</label>
                        <select id="tgl_akhir" class="form-select form-select-sm mx-2">
                            @foreach ($bulan as $row)
                                <option value="{{ $row->id_bln }}" {{ strtolower($row->nm_bulan) == 'juni' ? 'selected' : ''}}>{{ $row->nm_bulan }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary proses">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                <path
                                    d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                            </svg>
                        </button>
                    </div>
                
                </div>
                <div id="content" class="table-responsive"></div>
            </div>
        </div>
    </div>

    <script>
        function showData() {
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ route('lr.activity') }}`,
                type: "POST",
                dataType: 'json',
                data: {
                    tahun : $('#tahun').val(),
                    awal : $('#tgl_awal').val(),
                    akhir : $('#tgl_akhir').val(),
                },
                success: function(res) {
                    if (Object.keys(res).length == 0) {
                        alert('Metode dan kegiatan belum ditentukan!');
                        return;
                    }
                    var first = Object.values(res)[0];
                    var cols = first.length;
    
                    html = `<table class='table table-striped table-bordered'>`
                    html += `<tr class='text-center'>` //buat heading
                    html += `<th>Metode</th>`
                    $.each(first, function(key, value) {
                        html += `<th>${value.nm_bulan}</th>`
                    })
                    html += `</tr>`
    
                    var index = 0
                    $.each(res, function(key, row) { //extract method
                        index += 1
                        html += `<tr class='text-center'>`
                        html += `<td>${key}</td>`
                        if (row.length != 0) { // kondisi belum ditentukan jadwal
                            $.each(row, function(k, v) { //extract mount
                                html += `<td>`
                                if (v.aktivitas.length == 1) { // cek jika acara hanya ada satu list
                                    html +=
                                        `${v.aktivitas[0].acara} <br> <a href='#'>(${date(v.aktivitas[0].tgl_awal) + ' - ' + date(v.aktivitas[0].tgl_akhir)})</a> <br><span class="badge bg-primary">${v.aktivitas[0].status}</span></p>`
                                } else {
                                    html += `<ul class='text-start'>`
                                    $.each(v.aktivitas, function(i, j) { // extract event list
                                        html +=
                                            `<li>${j.acara} <br> <a href='#'>(${date(j.tgl_awal) + ' - ' + date(j.tgl_akhir)})</a> <br><span class="badge bg-primary">${j.status}</span></li>`
                                    })
                                    html += `</ul>`
                                }
                                html += `</td>`
                            })
                        } else {
                            if (index == Object.keys(res).length) {
                                html += `<td colspan='${cols}'>Sesuai Penugasan</td>`
                            } else {
                                html += `<td colspan='${cols}'>Tidak Ada</td>`
                            }
                        }
                        html += `</tr>`
                    })
                    html += `</table>`
    
                    //set to dom content
                    $('#content').html(html)
                }
            });
        }

        showData()

        $('body').on('click', '.proses', function(){
            showData()
        })
        $('body').on('change', '#tahun', function(){
            showData()
        })

    </script>
@endsection
