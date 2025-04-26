@php

@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Invoice Donasi</title>
    <style>
        body {
            background: linear-gradient(to bottom, #00a79d 50%, #ffffff 50%);
        }
        .container-md {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background-color: #fff;
            box-shadow: 0 10px 20px -10px rgba(0, 0, 0, 0.5);
            border-radius: 5px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .card-body p {
            margin-bottom: 10px;
        }
        .card-body table {
            width: 100%;
            border-collapse: collapse;
        }
        .card-body th,
        .card-body td {
            padding: 8px;
            border-bottom: 1px solid #fff;
            text-align: left;
        }
        .card-body th {
            width: 30%;
            font-weight: normal;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 30%;
        }
        .success-alert {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            background-color: #6e7276;
            color: #fff;
            padding: 10px;
            margin-bottom: 20px;
        }
        .content {
            font-size: 14px;
            color: #6e7276;
        }
        .content a {
            color: #6e7276;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-md">
        <div class="card">
            <div class="card-body" style="margin: 20px 20px 20px 20px;">
                <div class="logo">
                    <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" alt="logo-ldksyahid">
                </div>
                <div class="success-alert">
                    <p>Invoice Donasi Kamu</p>
                </div>
                <div class="content">
                    <div>
                        Assalammualaikum, {{ $donaturName }}
                        <br>
                        Jazakallah Khairan Katsiiran karena kamu telah ingin melakukan donasi untuk campaign {{ $campaignName }}, Yuk segera transfer donasimu <a href="{{ $invoiceUrl }}" target="_blank" rel="noopener noreferrer" style="color:blue; text-decoration:underline;">disini</a> sebelum link tersebut kadaluarsa.
                        <br>
                        Berikut detail Invoice Kamu :
                    </div>
                    <table>
                        <tr>
                            <th>Nama Campaign</th>
                            <td style="width: 1px">:</td>
                            <td>{{ $campaignName }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Donasi</th>
                            <td style="width: 1px">:</td>
                            <td>{{ $donationAmount }}</td>
                        </tr>
                        <tr>
                            <th>Mitra Donasi</th>
                            <td style="width: 1px">:</td>
                            <td>{{ $merchantName }}</td>
                        </tr>
                        <tr>
                            <th>Pesan Dari Kamu</th>
                            <td style="width: 1px">:</td>
                            {{ $donaturMessage }}
                        </tr>
                        <tr>
                            <th>Link Status Donasi</th>
                            <td style="width: 1px">:</td>
                            <td><a href="{{ env('APP_URL') }}/celengansyahid/yuk-donasi/{{ $linkCampaign }}/status/{{ $donationID }}" target="_blank" rel="noopener noreferrer" style="color: blue; font-size:12px; text-decoration:underline;">{{ env('APP_URL') }}/celengansyahid/yuk-donasi/{{ $linkCampaign }}/status/{{ $donationID }}</a></td>
                        </tr>
                        <tr>
                            <th>Deadline Transfer</th>
                            <td style="width: 1px">:</td>
                            <td>{{ $expiredDate }}</td>
                        </tr>
                    </table>
                    <div>
                        Terimakasih telah menjadi bagian dari Manusia Baik
                        <br>
                        Wassalammu'alaikum
                        <br>
                        Salam Hangat, UKM LDK Syahid
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
