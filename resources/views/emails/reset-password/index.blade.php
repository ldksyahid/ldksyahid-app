<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Reset Password – LDK Syahid</title>
    <style>
        @media only screen and (max-width: 600px) {
            .card      { width: 100% !important; }
            .card-pad  { padding: 28px 24px !important; }
            .hdr-pad   { padding: 28px 24px !important; }
            .sub-pad   { padding: 0 24px 20px !important; }
            .ftr-pad   { padding: 20px 24px !important; }
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
                        style="background:linear-gradient(135deg,#00a79d 0%,#00c4b8 100%);padding:36px 40px;">
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
                            UIN Syarif Hidayatullah Jakarta
                        </div>
                    </td>
                </tr>

                <!-- ── Body ── -->
                <tr>
                    <td class="card-pad" style="padding:36px 40px;">

                        <!-- Greeting -->
                        <h1 style="margin:0 0 6px;font-size:22px;color:#1a202c;font-weight:700;line-height:1.3;">
                            Assalamu'alaikum, {{ $name }}! 👋
                        </h1>
                        <p style="margin:0 0 22px;font-size:15px;color:#4a5568;line-height:1.65;">
                            Kami menerima permintaan untuk mereset password akun kamu di
                            <strong style="color:#00a79d;">LDK Syahid</strong>.
                            Klik tombol di bawah untuk membuat password baru.
                        </p>

                        <!-- CTA Button -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:28px 0;">
                            <tr><td align="center">
                                <a href="{{ $url }}" target="_blank" rel="noopener"
                                   style="display:inline-block;background:#00a79d;color:#ffffff;font-size:15px;font-weight:600;text-decoration:none;padding:14px 38px;border-radius:50px;letter-spacing:0.2px;mso-padding-alt:0;border-top:14px solid #00a79d;border-bottom:14px solid #00a79d;border-left:38px solid #00a79d;border-right:38px solid #00a79d;">
                                    🔑&nbsp;&nbsp;Reset Password Sekarang
                                </a>
                            </td></tr>
                        </table>

                        <!-- Info box -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                               style="background:#f0fffe;border:1px solid #b2ede9;border-radius:10px;margin:0 0 24px;">
                            <tr><td style="padding:13px 16px;font-size:13px;color:#1a6b66;line-height:1.6;">
                                ⏳&nbsp; Link reset password ini <strong>hanya berlaku selama 60 menit</strong>.
                                Jika sudah kadaluarsa, kamu bisa meminta link baru dari halaman lupa password.
                            </td></tr>
                        </table>

                        <!-- Closing note -->
                        <p style="margin:0;font-size:13px;color:#a0aec0;line-height:1.6;">
                            Jika kamu tidak merasa meminta reset password, abaikan saja email ini — akun kamu tetap aman dan tidak ada perubahan yang dilakukan.
                        </p>

                    </td>
                </tr>

                <!-- ── Subcopy (fallback link) ── -->
                <tr>
                    <td class="sub-pad" style="padding:0 40px 28px;border-top:1px solid #e2e8f0;">
                        <p style="margin:22px 0 6px;font-size:12px;color:#a0aec0;line-height:1.5;">
                            Jika tombol di atas tidak berfungsi, salin dan tempel link berikut ke browser kamu:
                        </p>
                        <p style="margin:0;font-size:11px;color:#718096;word-break:break-all;line-height:1.5;">
                            <a href="{{ $url }}" style="color:#00a79d;text-decoration:underline;">{{ $url }}</a>
                        </p>
                    </td>
                </tr>

                <!-- ── Footer ── -->
                <tr>
                    <td class="ftr-pad" align="center"
                        style="background:#f7fafc;padding:24px 40px;border-top:1px solid #e2e8f0;border-radius:0 0 16px 16px;">
                        <p style="margin:0 0 3px;font-size:13px;font-weight:600;color:#4a5568;">
                            Barakallahu fiikum 🤍
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
