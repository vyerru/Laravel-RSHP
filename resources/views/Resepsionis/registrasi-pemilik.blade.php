<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor WhatsApp</th>
            <th>Alamat</th>
            <th>Nama Pemilik</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($Pemilik as $index => $data_pemilik)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $data_pemilik->no_wa }}</td>
            <td>{{ $data_pemilik->alamat }}</td>
            <td>{{ $data_pemilik->user->nama }}</td>
        </tr>
        @endforeach
    </tbody>
</table>