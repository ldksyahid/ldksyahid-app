<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Invoice Donasi – LDK Syahid</title>
    <style>
        @media only screen and (max-width: 600px) {
            .card     { width: 100% !important; }
            .hdr-pad  { padding: 28px 20px !important; }
            .body-pad { padding: 24px 20px !important; }
            .ftr-pad  { padding: 20px !important; }
            .det-th   { width: 38% !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#edf2f7;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;-webkit-text-size-adjust:none;">

    <!-- Wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#edf2f7;padding:48px 16px;">
        <tr><td align="center">

            <!-- Card -->
            <table class="card" width="560" cellpadding="0" cellspacing="0" role="presentation"
                   style="max-width:560px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

                <!-- ── Header ── -->
                <tr>
                    <td class="hdr-pad" align="center"
                        style="background:linear-gradient(135deg,#00a79d 0%,#00c4b8 100%);padding:32px 40px;">
                        <table cellpadding="0" cellspacing="0" role="presentation" style="margin:0 auto 14px;">
                            <tr><td style="background:#ffffff;border-radius:18px;padding:8px;box-shadow:0 0 0 3px rgba(255,255,255,0.35);">
                                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
                                     width="64" height="64" alt="LDK Syahid"
                                     style="border-radius:12px;display:block;" />
                            </td></tr>
                        </table>
                        <div style="color:#ffffff;font-size:20px;font-weight:700;letter-spacing:-0.3px;line-height:1.2;">
                            LDK Syahid
                        </div>
                        <div style="color:rgba(255,255,255,0.8);font-size:12px;margin-top:5px;letter-spacing:0.2px;">
                            Celengan Syahid – Invoice Donasi
                        </div>
                    </td>
                </tr>

                <!-- ── Badge row ── -->
                <tr>
                    <td align="center" style="background:#f0fffe;padding:12px 16px;border-bottom:1px solid #e2e8f0;">
                        <span style="display:inline-block;background:#00a79d;color:#ffffff;font-size:12px;font-weight:600;padding:4px 16px;border-radius:50px;letter-spacing:0.4px;">
                            🧾 &nbsp;Invoice Donasi Kamu
                        </span>
                    </td>
                </tr>

                <!-- ── Body ── -->
                <tr>
                    <td class="body-pad" style="padding:32px 40px;">

                        <!-- Greeting -->
                        <h1 style="margin:0 0 6px;font-size:20px;color:#1a202c;font-weight:700;line-height:1.3;">
                            Assalamu'alaikum, {{ $donaturName }}! 🤍
                        </h1>
                        <p style="margin:0 0 8px;font-size:14px;color:#4a5568;line-height:1.65;">
                            Jazakallahu Khairan Katsiiran atas niat baikmu untuk berdonasi pada campaign
                            <strong style="color:#00a79d;">{{ $campaignName }}</strong>.
                        </p>
                        <p style="margin:0 0 24px;font-size:14px;color:#4a5568;line-height:1.65;">
                            Segera selesaikan transfermu melalui link invoice di bawah sebelum kadaluarsa ya!
                        </p>

                        <!-- CTA Button -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:0 0 28px;">
                            <tr><td align="center">
                                <a href="{{ $invoiceUrl }}" target="_blank" rel="noopener"
                                   style="display:inline-block;background:#00a79d;color:#ffffff;font-size:14px;font-weight:600;text-decoration:none;padding:13px 36px;border-radius:50px;letter-spacing:0.2px;mso-padding-alt:0;border-top:13px solid #00a79d;border-bottom:13px solid #00a79d;border-left:36px solid #00a79d;border-right:36px solid #00a79d;">
                                    💳&nbsp;&nbsp;Bayar Invoice Sekarang
                                </a>
                            </td></tr>
                        </table>

                        <!-- Detail Table -->
                        <div style="font-size:13px;font-weight:600;color:#4a5568;margin-bottom:10px;text-transform:uppercase;letter-spacing:0.5px;">
                            Detail Donasi
                        </div>
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                               style="border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;font-size:14px;">

                            <tr style="background:#f7fafc;">
                                <td class="det-th" style="padding:11px 14px;color:#718096;font-size:13px;width:36%;border-bottom:1px solid #e2e8f0;">
                                    Nama Campaign
                                </td>
                                <td style="padding:11px 14px;color:#1a202c;font-weight:500;border-bottom:1px solid #e2e8f0;">
                                    {{ $campaignName }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:11px 14px;color:#718096;font-size:13px;border-bottom:1px solid #e2e8f0;">
                                    Jumlah Donasi
                                </td>
                                <td style="padding:11px 14px;color:#00a79d;font-weight:700;border-bottom:1px solid #e2e8f0;">
                                    {{ $donationAmount }}
                                </td>
                            </tr>

                            <tr style="background:#f7fafc;">
                                <td style="padding:11px 14px;color:#718096;font-size:13px;border-bottom:1px solid #e2e8f0;">
                                    Mitra Donasi
                                </td>
                                <td style="padding:11px 14px;color:#1a202c;font-weight:500;border-bottom:1px solid #e2e8f0;">
                                    {{ $merchantName }}
                                </td>
                            </tr>

                            @if(!empty($donaturMessage))
                            <tr>
                                <td style="padding:11px 14px;color:#718096;font-size:13px;border-bottom:1px solid #e2e8f0;">
                                    Pesan Kamu
                                </td>
                                <td style="padding:11px 14px;color:#1a202c;border-bottom:1px solid #e2e8f0;">
                                    {{ $donaturMessage }}
                                </td>
                            </tr>
                            @endif

                            <tr style="background:#f7fafc;">
                                <td style="padding:11px 14px;color:#718096;font-size:13px;border-bottom:1px solid #e2e8f0;">
                                    Deadline Transfer
                                </td>
                                <td style="padding:11px 14px;color:#e53e3e;font-weight:600;border-bottom:1px solid #e2e8f0;">
                                    ⏰ &nbsp;{{ $expiredDate }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:11px 14px;color:#718096;font-size:13px;">
                                    Status Donasi
                                </td>
                                <td style="padding:11px 14px;">
                                    <a href="{{ env('APP_URL') }}/celengansyahid/yuk-donasi/{{ $linkCampaign }}/status/{{ $donationID }}"
                                       target="_blank" rel="noopener"
                                       style="color:#00a79d;text-decoration:underline;font-size:13px;word-break:break-all;">
                                        Cek Status Donasi &rarr;
                                    </a>
                                </td>
                            </tr>

                        </table>

                        <!-- Closing note -->
                        <p style="margin:24px 0 0;font-size:13px;color:#a0aec0;line-height:1.6;">
                            Terimakasih telah menjadi bagian dari <strong style="color:#4a5568;">Manusia Baik</strong>.
                            Semoga Allah ﷻ membalas kebaikanmu dengan berlipat ganda. 🤲
                        </p>

                    </td>
                </tr>

                <!-- ── Footer ── -->
                <tr>
                    <td class="ftr-pad" align="center"
                        style="background:#f7fafc;padding:22px 40px;border-top:1px solid #e2e8f0;border-radius:0 0 16px 16px;">
                        <p style="margin:0 0 3px;font-size:13px;font-weight:600;color:#4a5568;">
                            Wassalamu'alaikum Warahmatullahi Wabarakatuh 🤍
                        </p>
                        <p style="margin:0;font-size:12px;color:#a0aec0;">
                            Tim LDK Syahid · UIN Syarif Hidayatullah Jakarta
                        </p>
                        <p style="margin:8px 0 0;font-size:11px;color:#cbd5e0;letter-spacing:0.3px;">
                            #KitaAdalahSaudara
                        </p>
                    </td>
                </tr>

            </table>

            <!-- Bottom copyright -->
            <table width="560" cellpadding="0" cellspacing="0" role="presentation" style="max-width:560px;">
                <tr><td style="padding:18px 0;text-align:center;font-size:11px;color:#a0aec0;">
                    © {{ date('Y') }} UKM LDK Syahid UIN Syarif Hidayatullah Jakarta. All rights reserved.
                </td></tr>
            </table>

        </td></tr>
    </table>

</body>
</html>
