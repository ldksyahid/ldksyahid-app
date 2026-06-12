<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Log which field(s) rejected the donation so "silently bounced back to the
     * form" can be diagnosed (e.g. an empty/failed reCAPTCHA leaves no other trace).
     */
    protected function failedValidation(Validator $validator)
    {
        Log::warning('StoreDonationRequest validation failed', [
            'errors' => $validator->errors()->toArray(),
            'ip'     => $this->ip(),
        ]);

        parent::failedValidation($validator);
    }

    public function rules(): array
    {
        return [
            'jumlah_donasi'       => ['required', 'string', 'max:20'],
            'nama_donatur'        => ['required', 'string', 'max:100'],
            'email_donatur'       => ['required', 'email', 'max:150'],
            'no_telp_donatur'     => ['required', 'string', 'regex:/^[0-9+\-\s]{7,20}$/'],
            'pesan_donatur'       => ['nullable', 'string', 'max:500'],
            'is_anonymous'        => ['nullable', 'in:0,1'],
            'usia_donatur'        => ['nullable', 'string', 'max:50'],
            'domisili_donatur'    => ['nullable', 'string', 'max:100'],
            'pekerjaan_donatur'   => ['nullable', 'string', 'max:100'],
            'linkcampaign'        => ['required', 'string', 'max:255', 'exists:campaigns,link'],
            'postdonation'        => ['required', 'string', 'max:36', 'exists:campaigns,id'],
            'g-recaptcha-response'=> $this->recaptchaRules(),
        ];
    }

    /**
     * reCAPTCHA validation rules. Verification can be toggled off via
     * RECAPTCHA_ENABLED=false (temporary, e.g. while migrating a deprecated key).
     */
    protected function recaptchaRules(): array
    {
        if (!config('services.recaptcha_enabled', true)) {
            return ['nullable'];
        }

        return ['required', function ($attribute, $value, $fail) {
            try {
                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => config('recaptcha.api_secret_key'),
                    'response' => $value,
                    'remoteip' => $this->ip(),
                ]);
                $result = $response->json() ?: [];
            } catch (\Throwable $e) {
                Log::error('reCAPTCHA verify exception: ' . $e->getMessage());
                $result = [];
            }

            // Logs Google's full response (incl. error-codes) so the exact
            // reject reason is visible: invalid-input-secret / hostname-mismatch /
            // timeout-or-duplicate / etc.
            Log::info('reCAPTCHA verify result', ['result' => $result]);

            if (empty($result['success'])) {
                $fail('Verifikasi Captcha gagal. Silakan coba lagi.');
            }
        }];
    }

    public function messages(): array
    {
        return [
            'nama_donatur.required'         => 'Nama donatur wajib diisi.',
            'email_donatur.required'        => 'Email donatur wajib diisi.',
            'email_donatur.email'           => 'Format email tidak valid.',
            'no_telp_donatur.required'      => 'Nomor telepon wajib diisi.',
            'no_telp_donatur.regex'         => 'Format nomor telepon tidak valid.',
            'jumlah_donasi.required'        => 'Jumlah donasi wajib diisi.',
            'linkcampaign.required'         => 'Campaign tidak ditemukan.',
            'linkcampaign.exists'           => 'Campaign tidak ditemukan.',
            'postdonation.required'         => 'ID campaign wajib diisi.',
            'postdonation.exists'           => 'Campaign tidak valid.',
            'g-recaptcha-response.required' => 'Silakan verifikasi Captcha terlebih dahulu.',
            'g-recaptcha-response.recaptcha' => 'Verifikasi Captcha gagal. Silakan coba lagi.',
        ];
    }
}
