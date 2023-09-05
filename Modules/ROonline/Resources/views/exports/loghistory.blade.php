<html>
<style>
    table tr th{
        background-color: #1E88E5;
        color: #FFF;
    }
</style>
<table>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>OKP</th>
        <th>PRODUCT</th>
        <th>LOT Number</th>
        <th>Expire Date</th>
        <th>LINE Process</th>
        <th>Ro (%)</th>
    </tr>
    @foreach ($loghistories as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ date('d-m-Y', strtotime($item->TimeStamp)) }}</td>
            <td>{{ date('H:i:s', strtotime($item->TimeStamp)) }}</td>
            <td>{{ $item->txtBatchOrder }}</td>
            <td>{{ $item->txtProductName }}</td>
            <td>{{ $item->txtProductionCode }}</td>
            <td>{{ $item->dtmExpireDate }}</td>
            <td>{{ $item->txtLineProcessName }}</td>
            <td>{{ $item->floatValues }}</td>
        </tr>
    @endforeach
</table>
</html>