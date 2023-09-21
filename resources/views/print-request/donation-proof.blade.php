
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Bukti Pembayaran Donasi - {{ $donation->id }}</title>

		<!-- Favicon -->
		<link rel="icon" href="{{ asset('Images/Logos/logoldksyahid.png') }}" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				/* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>


		<div class="invoice-box next" style="height: 950px;">
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="data:image/png;base64,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" data-filename="LOGO Syahid (3) (2).png" style="width: 151.768px; height: 162px;">
								</td>

								<td>
                                    ID Donasi : {{ $donation->id }} <br>
									{{ \Carbon\Carbon::parse( date("Y-m-d") )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( date("Y-m-d") )->isoFormat('D') }} {{ \Carbon\Carbon::parse( date("Y-m-d") )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( date("Y-m-d") )->isoFormat('Y') }} <br> ({{ \Carbon\Carbon::parse( date("h:i:sa") )->format('H:i T') }})<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Gedung Student Center <br> Lantai 3 Ruang LDK Syahid,<br />
                                    UIN Syarif Hidayatullah Jakarta
								</td>

								<td>
									UKM LDK Syahid <br />
									UIN Syarif Hidayatullah Jakarta<br />
									ldk@uinjkt.ac.id
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>#</td>

					<td>#</td>
				</tr>

                <tr class="details">
					<td>Status Pembayaran</td>

                    @if ($donation->payment_status == 'PAID')
                        <td>Dibayar</td>
                    @elseif($donation->payment_status == 'PENDING')
                        <td>Tertunda</td>
                    @else
                        <td>Gagal</td>
                    @endif
				</tr>

				<tr class="details">
					<td>Atas Nama</td>

					<td>{{ $donation->nama_donatur }}</td>
				</tr>

                <tr class="details">
					<td>Email</td>

					<td>{{ $donation->email_donatur }}</td>
				</tr>

                <tr class="details">
					<td>Kontak</td>

					<td>{{ $donation->no_telp_donatur }}</td>
				</tr>

                <tr class="details">
					<td><i>Campaign</i></td>

					<td>{{ $campaign->judul }}</td>
				</tr>

                <tr class="details">
					<td>Donasi</td>

					<td>{{ LFC::formatRupiah($donation->jumlah_donasi) }}</td>
				</tr>

				<tr class="total">
					<td></td>

					<td>Total: {{ LFC::formatRupiah($donation->jumlah_donasi) }}</td>
				</tr>
			</table>
            <div style="text-align: start; font-size:12px;">
                <br><br><br><br><br><br><br>
                <p><i>*Bukti Pembayaran yang Sah yang dikeluarkan oleh UKM LDK Syahid UIN Syarif Hidayatullah Jakarta</i></p>
            </div>
		</div>


<script>
    window.onafterprint = window.close;
         window.print();
</script>
