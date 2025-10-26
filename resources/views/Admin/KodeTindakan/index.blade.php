<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Deskripsi Tindakan Terapi</th>
            <th>Kategori</th>
            <th>Kategori Klinis</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kodeTindakan as $isi_data)
        <tr>
            <td>{{ $isi_data->idkode_tindakan_terapi }}</td>
            <td>{{ $isi_data->kode }}</td>
            <td>{{ $isi_data->deskripsi_tindakan_terapi }}</td>
            <td>{{ $isi_data->kategori->nama_kategori }}</td>
            <td>{{ $isi_data->kategoriKlinis->nama_kategori_klinis }}</td>
        </tr>
        @endforeach
    </tbody>
</table>