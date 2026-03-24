<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jumlah_donasi'       => ['required', 'string', 'max:20'],
            'nama_donatur'        => ['required', 'string', 'max:100'],
            'email_donatur'       => ['required', 'email', 'max:150'],
            'no_telp_donatur'     => ['required', 'string', 'regex:/^[0-9+\-\s]{7,20}$/'],
            'pesan_donatur'       => ['nullable', 'string', 'max:500'],
            'usia_donatur'        => ['nullable', 'string', 'max:50'],
            'domisili_donatur'    => ['nullable', 'string', 'max:100'],
            'pekerjaan_donatur'   => ['nullable', 'string', 'max:100'],
            'linkcampaign'        => ['required', 'string', 'max:255', 'exists:campaigns,link'],
            'postdonation'        => ['required', 'string', 'max:36', 'exists:campaigns,id'],
            'g-recaptcha-response'=> ['required', 'string'],
        ];
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
        ];
    }
}
