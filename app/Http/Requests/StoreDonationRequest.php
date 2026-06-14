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
     * RECAPTCHA_TYPE controls "score" (Enterprise invisible) vs "checkbox".
     */
    protected function recaptchaRules(): array
    {
        if (!config('services.recaptcha_enabled', true)) {
            return ['nullable'];
        }

        return ['required', function ($_attribute, $value, $fail) {
            $type = config('services.recaptcha_type', 'score');

            if ($type === 'score') {
                $this->verifyEnterpriseScore($value, $fail);
            } else {
                $this->verifyEnterpriseCheckbox($value, $fail);
            }
        }];
    }

    /**
     * Verify via reCAPTCHA Enterprise Assessment API (score-based).
     * Returns a risk score 0.0–1.0; scores >= threshold are considered human.
     */
    private function verifyEnterpriseScore(string $token, callable $fail): void
    {
        $projectId = config('services.recaptcha_project_id');
        $apiKey    = config('services.recaptcha_api_key');
        $siteKey   = config('recaptcha.api_site_key');
        $threshold = config('services.recaptcha_score_threshold', 0.5);

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://recaptchaenterprise.googleapis.com/v1/projects/{$projectId}/assessments?key={$apiKey}", [
                    'event' => [
                        'token'          => $token,
                        'expectedAction' => 'submit_donation',
                        'siteKey'        => $siteKey,
                    ],
                ]);
            $result = $response->json() ?: [];
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA Enterprise score verify exception: ' . $e->getMessage());
            $fail('Verifikasi Captcha gagal. Silakan coba lagi.');
            return;
        }

        $valid         = $result['tokenProperties']['valid']         ?? false;
        $invalidReason = $result['tokenProperties']['invalidReason'] ?? '';
        $score         = $result['riskAnalysis']['score']            ?? 0.0;
        $action        = $result['tokenProperties']['action']        ?? '';

        // DUPE means the token was already used in a previous assessment that
        // passed — the user is human. Allow it rather than blocking a retry
        // caused by a server-side error on the first attempt.
        if ($invalidReason === 'DUPE') {
            return;
        }

        if (!$valid || $action !== 'submit_donation' || $score < $threshold) {
            $fail('Verifikasi Captcha gagal. Silakan coba lagi.');
        }
    }

    /**
     * Verify via reCAPTCHA Enterprise Assessment API (checkbox).
     * Checkbox tokens are also verified through the Enterprise endpoint.
     */
    private function verifyEnterpriseCheckbox(string $token, callable $fail): void
    {
        $projectId = config('services.recaptcha_project_id');
        $apiKey    = config('services.recaptcha_api_key');
        $siteKey   = config('recaptcha.api_site_key');

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://recaptchaenterprise.googleapis.com/v1/projects/{$projectId}/assessments?key={$apiKey}", [
                    'event' => [
                        'token'   => $token,
                        'siteKey' => $siteKey,
                    ],
                ]);
            $result = $response->json() ?: [];
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA Enterprise checkbox verify exception: ' . $e->getMessage());
            $fail('Verifikasi Captcha gagal. Silakan coba lagi.');
            return;
        }

        if (empty($result['tokenProperties']['valid'])) {
            $fail('Verifikasi Captcha gagal. Silakan coba lagi.');
        }
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
