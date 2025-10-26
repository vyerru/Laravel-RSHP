<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Role</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roleUser as $index => $isi_data)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $isi_data->user->nama }}</td>
            <td>{{ $isi_data->role->nama_role }}</td>
            <td>{{ $isi_data->status_label }}</td>
        </tr>
        @endforeach
    </tbody>
</table>