<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>id pet</th>
            <th>Nama Pet</th>
            <th>Tanggal Lahir</th>
            <th>Warna Tanda</th>
            <th>Jenis Kelamin</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pet as $index => $isi_data)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $isi_data->idpet }}</td>
            <td>{{ $isi_data->nama }}</td>
            <td>{{ $isi_data->tanggal_lahir }}</td>
            <td>{{ $isi_data->warna_tanda }}</td>
            <td>{{ $isi_data->jenis_kelamin }}</td>
        </tr>
        @endforeach
    </tbody>
</table>