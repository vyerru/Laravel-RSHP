<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori Klinis</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kategoriKlinis as $isi_data)
        <tr>
            <td>{{ $isi_data->idkategori_klinis }}</td>
            <td>{{ $isi_data->nama_kategori_klinis }}</td>
        </tr>
        @endforeach
    </tbody>
</table>