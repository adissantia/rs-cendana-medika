<!DOCTYPE html>
<html>
<head>
    <title>Tiket Appointment</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .ticket{
            border:2px dashed #333;
            padding:30px;
            border-radius:10px;
        }

        .title{
            text-align:center;
            font-size:24px;
            font-weight:bold;
        }

        .subtitle{
            text-align:center;
            color:#666;
            margin-top:5px;
        }

        .queue{
            text-align:center;
            font-size:48px;
            color:#2563eb;
            margin:20px 0;
            font-weight:bold;
        }

        table{
            width:100%;
            margin-top:20px;
        }

        td{
            padding:8px 0;
        }

        .barcode{
            text-align:center;
            margin-top:30px;
        }

        .code{
            margin-top:10px;
            font-weight:bold;
        }

    </style>

</head>
<body>

<div class="ticket">

    <div class="title">
        TIKET APPOINTMENT
    </div>

    <div class="subtitle">
        RS Cendana Medika
    </div>

    <div class="queue">
        {{ $appointment->queue_number }}
    </div>

    <table>

        <tr>
            <td>Pasien</td>
            <td>: {{ $appointment->patient->name }}</td>
        </tr>

        <tr>
            <td>Dokter</td>
            <td>: {{ $appointment->doctor->name }}</td>
        </tr>

        <tr>
            <td>Tanggal</td>
            <td>: {{ $appointment->appointment_date->format('d M Y') }}</td>
        </tr>

        <tr>
            <td>Jam</td>
            <td>: {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
        </tr>

        <tr>
            <td>Status</td>
            <td>: {{ ucfirst($appointment->status) }}</td>
        </tr>

    </table>

    <div class="barcode">

        <img
            src="https://barcode.tec-it.com/barcode.ashx?data={{ $appointment->booking_code }}&code=Code128"
            width="250">

        <div class="code">
            {{ $appointment->booking_code }}
        </div>

    </div>

</div>

</body>
</html>