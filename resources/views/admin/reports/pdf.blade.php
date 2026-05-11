<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan RS</title>

    <style>
        body{
            font-family: sans-serif;
            font-size: 12px;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:20px;
        }

        th, td{
            border:1px solid #ccc;
            padding:8px;
            text-align:left;
        }

        th{
            background:#f3f4f6;
        }

        h1{
            margin-bottom:5px;
        }

        .summary{
            margin-top:20px;
        }
    </style>
</head>
<body>

    <h1>RS Cendana Medika</h1>
    <p>Laporan Statistik Rumah Sakit</p>

    <div class="summary">
        <p>Total Appointment: {{ $totalAppointments }}</p>
        <p>Janji Selesai: {{ $completedAppointments }}</p>
        <p>Dibatalkan: {{ $cancelledAppointments }}</p>
        <p>
            Total Pendapatan:
            Rp {{ number_format($totalRevenue,0,',','.') }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Biaya</th>
            </tr>
        </thead>

        <tbody>

            @foreach($appointments as $item)

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ $item->patient->name ?? '-' }}
                </td>

                <td>
                    {{ $item->doctor->name ?? '-' }}
                </td>

                <td>
                    {{ $item->appointment_date }}
                </td>

                <td>
                    {{ ucfirst($item->status) }}
                </td>

                <td>
                    Rp {{ number_format($item->fee,0,',','.') }}
                </td>
            </tr>

            @endforeach

        </tbody>
    </table>

</body>
</html>