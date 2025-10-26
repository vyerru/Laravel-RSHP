<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Ras</th>
            <th>Jenis Hewan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rasHewan as $isi_data)
        <tr>
            <td>{{ $isi_data->idras_hewan }}</td>
            <td>{{ $isi_data->nama_ras }}</td>
            <td>{{ $isi_data->jenisHewan->nama_jenis_hewan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>