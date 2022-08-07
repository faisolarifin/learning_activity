<table border="1">
    <tr>
        <th>Metode</th>
        @foreach (array_values($result)[0] as $k)
            <th>
                {{$k->nm_bulan}}
            </th>   
        @endforeach
    </tr>
    @php($index=0)
    @foreach ($result as $key => $row)
        @php($index += 1)
        <tr>
            <td>{{$key}}</td>

            @if (count($row) != 0)
                @foreach ($row as $i)

                    <td>
                        <ul>
                            @foreach ($i->aktifitas as $j)
                                <li>{{$j->acara. $j->tgl_awal. $j->tgl_akhir}}</li>           
                            @endforeach
                        </ul>
                    </td>              
                @endforeach
            @else
                @php($cols = count(array_values($result)[0]))
                @if ($index == count($result))
                    <td colspan="{{$cols}}">Sesuai Penugasan</td>
                    @continue
                @endif
                <td colspan="{{$cols}}">Tidak Ada</td>
            @endif

        </tr>  
    @endforeach

</table>