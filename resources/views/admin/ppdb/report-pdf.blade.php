<!DOCTYPE html>
<html>
<head>
    <title>Laporan PPDB</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        @media print {
            body { margin: 0; }
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PPDB</h2>
        <h3>SMK BAKTI NUSANTARA 666</h3>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Pendaftaran</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
                <th>Status</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $index => $registration)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $registration->registration_number }}</td>
                <td>{{ $registration->name }}</td>
                <td>{{ $registration->email }}</td>
                <td>{{ $registration->major }}</td>
                <td>{{ $registration->status }}</td>
                <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Total Pendaftar: {{ $registrations->count() }}</strong></p>
    </div>
</body>
</html>