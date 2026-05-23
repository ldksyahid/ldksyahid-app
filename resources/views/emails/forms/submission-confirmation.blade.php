<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Konfirmasi Pengiriman Formulir – LDK Syahid</title>
    <style>
        @media only screen and (max-width: 600px) {
            .card     { width: 100% !important; }
            .hdr-pad  { padding: 28px 20px !important; }
            .body-pad { padding: 24px 20px !important; }
            .ftr-pad  { padding: 20px !important; }
            .ans-table td { font-size: 13px !important; padding: 8px 10px !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#edf2f7;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;-webkit-text-size-adjust:none;">

    <!-- Outer wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#edf2f7;padding:48px 16px;">
        <tr><td align="center">

            <!-- Email card -->
            <table class="card" width="560" cellpadding="0" cellspacing="0" role="presentation"
                   style="max-width:560px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr>
                    <td class="hdr-pad" align="center"
                        style="background:linear-gradient(135deg,#00a79d 0%,#008b84 100%);padding:32px 40px;">

                        <!-- Org label -->
                        <p style="margin:0 0 14px;font-size:11px;color:rgba(255,255,255,0.7);letter-spacing:2px;text-transform:uppercase;">
                            ✦ LDK Syahid ✦
                        </p>

                        <!-- Icon badge -->
                        <div style="display:inline-block;background:rgba(255,255,255,0.15);border-radius:50%;width:56px;height:56px;line-height:56px;text-align:center;margin-bottom:14px;">
                            <span style="font-size:26px;">✅</span>
                        </div>

                        <h1 style="margin:0 0 8px;font-size:22px;font-weight:700;color:#ffffff;line-height:1.3;">
                            Alhamdulillah, Formulir Berhasil Dikirim!
                        </h1>
                        <p style="margin:0;font-size:14px;color:rgba(255,255,255,0.85);">
                            {{ $formTitle }}
                        </p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td class="body-pad" style="padding:32px 40px;">

                        <!-- Islamic greeting -->
                        <p style="margin:0 0 4px;font-size:14px;color:#374151;font-weight:600;font-style:italic;">
                            Assalamu'alaikum Warahmatullahi Wabarakatuh,
                        </p>

                        <!-- Name greeting -->
                        <p style="margin:0 0 12px;font-size:15px;color:#374151;font-weight:600;">
                            {{ $respondentName ?: 'Sobat Syahid' }}
                        </p>

                        <p style="margin:0 0 8px;font-size:14px;color:#6b7280;line-height:1.7;">
                            Jazakumullahu Khairan atas partisipasi Anda dalam mengisi formulir
                            <strong style="color:#00a79d;">{{ $formTitle }}</strong>.
                            Berikut adalah ringkasan jawaban yang telah Anda kirimkan.
                        </p>

                        <!-- Submission timestamp -->
                        <p style="margin:0 0 20px;font-size:12px;color:#9ca3af;">
                            Dikirim pada: {{ $submittedAt }}
                        </p>

                        <!-- Divider -->
                        <hr style="border:none;border-top:1px solid #e5e7eb;margin:0 0 20px;" />

                        <!-- Answers table -->
                        <table class="ans-table" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                               style="border-collapse:collapse;width:100%;border-radius:8px;overflow:hidden;border:1px solid #e5e7eb;">
                            @foreach ($answers as $label => $value)
                                <tr style="background: {{ $loop->even ? '#f9fafb' : '#ffffff' }}">
                                    <td style="padding:10px 14px;font-size:13px;color:#6b7280;font-weight:600;
                                               border-bottom:1px solid #e5e7eb;width:40%;vertical-align:top;">
                                        {{ $label }}
                                    </td>
                                    <td style="padding:10px 14px;font-size:13px;color:#111827;
                                               border-bottom:1px solid #e5e7eb;vertical-align:top;word-break:break-word;">
                                        @if (str_starts_with((string) $value, 'https://'))
                                            <a href="{{ $value }}" style="color:#00a79d;text-decoration:none;font-weight:600;">
                                                {{ $value }}
                                            </a>
                                        @elseif ($value !== null && $value !== '')
                                            {{ $value }}
                                        @else
                                            <span style="color:#9ca3af;font-style:italic;">–</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <!-- Footer note -->
                        <p style="margin:24px 0 0;font-size:13px;color:#6b7280;line-height:1.7;padding:16px;background:#f0fdf4;border-radius:8px;">
                            Jika Anda tidak merasa mengisi formulir ini, abaikan email ini.
                            Data Anda tersimpan dengan aman oleh tim LDK Syahid.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td class="ftr-pad" align="center"
                        style="background:#f9fafb;padding:24px 40px;border-top:1px solid #e5e7eb;">
                        <p style="margin:0 0 6px;font-size:13px;color:#6b7280;font-style:italic;">
                            Wassalamu'alaikum Warahmatullahi Wabarakatuh
                        </p>
                        <p style="margin:0 0 4px;font-size:12px;color:#9ca3af;">
                            Email ini dikirim secara otomatis oleh sistem LDK Syahid.
                        </p>
                        <p style="margin:0 0 8px;font-size:12px;color:#9ca3af;">
                            Mohon tidak membalas email ini.
                        </p>
                        <p style="margin:0;font-size:12px;">
                            <a href="{{ config('app.url') }}" style="color:#00a79d;text-decoration:none;font-weight:600;">
                                {{ config('app.url') }}
                            </a>
                        </p>
                    </td>
                </tr>

            </table>

        </td></tr>
    </table>

</body>
</html>
