<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kategori as $isi_data)
        <tr>
            <td>{{ $isi_data->idkategori }}</td>
            <td>{{ $isi_data->nama_kategori }}</td>
        </tr>
        @endforeach
    </tbody>
</table>