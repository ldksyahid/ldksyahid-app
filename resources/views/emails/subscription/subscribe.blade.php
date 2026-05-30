<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Selamat Bergabung – LDK Syahid</title>
    <style>
        @media only screen and (max-width: 600px) {
            .card     { width: 100% !important; }
            .hdr-pad  { padding: 28px 20px !important; }
            .body-pad { padding: 24px 20px !important; }
            .ftr-pad  { padding: 20px !important; }
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
                            Konfirmasi Langganan
                        </div>
                    </td>
                </tr>

                <!-- ── Badge row ── -->
                <tr>
                    <td align="center" style="background:#f0fffe;padding:12px 16px;border-bottom:1px solid #e2e8f0;">
                        <span style="display:inline-block;background:#00a79d;color:#ffffff;font-size:12px;font-weight:600;padding:4px 16px;border-radius:50px;letter-spacing:0.4px;">
                            🎉 &nbsp;{{ $isResubscribe ? 'Selamat Datang Kembali!' : 'Kamu Berhasil Berlangganan!' }}
                        </span>
                    </td>
                </tr>

                <!-- ── Body ── -->
                <tr>
                    <td class="body-pad" style="padding:32px 40px;">

                        <!-- Greeting -->
                        <h1 style="margin:0 0 6px;font-size:20px;color:#1a202c;font-weight:700;line-height:1.3;">
                            Assalamu'alaikum 🤍
                        </h1>
                        @if($isResubscribe)
                        <p style="margin:0 0 16px;font-size:14px;color:#4a5568;line-height:1.65;">
                            Marhaban! Senang melihatmu kembali! Email <strong style="color:#00a79d;">{{ $email }}</strong>
                            kamu telah berhasil didaftarkan <strong>kembali</strong> ke daftar pelanggan LDK Syahid.
                        </p>
                        <p style="margin:0 0 28px;font-size:14px;color:#4a5568;line-height:1.65;">
                            Kamu kini aktif kembali dan akan menerima informasi terbaru seputar kegiatan, program, dan agenda
                            <strong>UKM LDK Syahid UIN Jakarta</strong> langsung di inboxmu. 🕌
                        </p>
                        @else
                        <p style="margin:0 0 16px;font-size:14px;color:#4a5568;line-height:1.65;">
                            Jazakallahu Khairan Katsiiran! Email <strong style="color:#00a79d;">{{ $email }}</strong>
                            kamu telah berhasil didaftarkan ke daftar pelanggan LDK Syahid.
                        </p>
                        <p style="margin:0 0 28px;font-size:14px;color:#4a5568;line-height:1.65;">
                            Kini kamu akan mendapatkan informasi terbaru seputar kegiatan, program, dan agenda
                            <strong>UKM LDK Syahid UIN Jakarta</strong> langsung di inboxmu. 🕌
                        </p>
                        @endif

                        <!-- Info box -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                               style="background:#f0fffe;border:1px solid #b2f5ea;border-radius:10px;margin-bottom:28px;">
                            <tr>
                                <td style="padding:16px 20px;">
                                    <p style="margin:0 0 6px;font-size:13px;font-weight:600;color:#00a79d;">
                                        📬 Apa yang akan kamu dapatkan?
                                    </p>
                                    <ul style="margin:0;padding-left:18px;font-size:13px;color:#4a5568;line-height:1.8;">
                                        <li>Informasi kegiatan & program terbaru LDK Syahid</li>
                                        <li>Update kajian & agenda dakwah kampus</li>
                                        <li>Informasi donasi & campaign sosial</li>
                                        <li>Konten inspiratif seputar kehidupan islami</li>
                                    </ul>
                                </td>
                            </tr>
                        </table>

                        <!-- CTA Button -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:0 0 24px;">
                            <tr><td align="center">
                                <a href="{{ config('app.url') }}" target="_blank" rel="noopener"
                                   style="display:inline-block;background:#00a79d;color:#ffffff;font-size:14px;font-weight:600;text-decoration:none;padding:13px 36px;border-radius:50px;letter-spacing:0.2px;mso-padding-alt:0;border-top:13px solid #00a79d;border-bottom:13px solid #00a79d;border-left:36px solid #00a79d;border-right:36px solid #00a79d;">
                                    🌐&nbsp;&nbsp;Kunjungi Website Kami
                                </a>
                            </td></tr>
                        </table>

                        <!-- Closing note -->
                        @if($isResubscribe)
                        <p style="margin:0;font-size:13px;color:#a0aec0;line-height:1.6;">
                            Jika kamu ingin berhenti berlangganan kembali, kamu dapat melakukannya
                            kapan saja melalui link unsubscribe di setiap email yang kami kirimkan.
                        </p>
                        @else
                        <p style="margin:0;font-size:13px;color:#a0aec0;line-height:1.6;">
                            Jika kamu merasa tidak mendaftar, abaikan email ini atau
                            hubungi kami melalui media sosial LDK Syahid.
                        </p>
                        @endif

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
