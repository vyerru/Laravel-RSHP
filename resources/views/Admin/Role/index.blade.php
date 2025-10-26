<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>nama_role</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($role as $index => $isi_data)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $isi_data->nama_role }}</td>
        </tr>
        @endforeach
    </tbody>
</table>