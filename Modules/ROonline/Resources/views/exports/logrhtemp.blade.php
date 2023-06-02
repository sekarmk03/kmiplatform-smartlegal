<html>
<table>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Line</th>
        <th>Area</th>
        <th>Temp</th>
        <th>RH</th>
    </tr>
    @foreach ($rhtemp as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ date('d-m-Y', strtotime($item->TimeStamp)) }}</td>
            <td>{{ date('H:i:s', strtotime($item->TimeStamp)) }}</td>
            <td>{{ ($item->txtLineProcessName == 'Sachet B'?'Canning':$item->txtLineProcessName) }}</td>
            <td>{{ $item->txtAreaName }}</td>
            <td>{{ $item->floatTemp }}</td>
            <td>{{ $item->floatRH }}</td>
        </tr>
    @endforeach
</table>
</html>