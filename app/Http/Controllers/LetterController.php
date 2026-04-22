<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LetterController extends Controller
{
    public function index()
    {
        // Menampilkan semua surat, diurutkan dari yang terbaru
        // Pakai with('creator') biar relasi ke tabel users kepanggil sekalian (ngebutin query)
        $letters = Letter::with('creator')->latest()->get();
        return view('admin-page.e-persuratan.index', compact('letters'));
    }

    public function create()
    {
        // Membuka halaman form pembuatan surat
        return view('admin-page.e-persuratan.create');
    }

    public function store(Request $request)
    {
        // Validasi inputan dari form
        $request->validate([
            'type' => 'required',
            'subject' => 'required',
            'destination' => 'required',
            'content' => 'required',
        ]);

        // Simpan ke database
        Letter::create([
            'type' => $request->type,
            'subject' => $request->subject,
            'destination' => $request->destination,
            'content' => $request->content,
            'status' => 'pending', // Langsung masuk status pending minta approval BPH
            'verification_hash' => Str::random(12), // Generate kode unik buat QR Link nanti
            'created_by' => auth()->id(), // Mencatat siapa HelperLetter yang bikin
        ]);

        return redirect()->route('admin.e-persuratan.index')
                         ->with('success', 'Surat berhasil dibuat dan sedang menunggu persetujuan!');
    }

    // FUNGSI BARU UNTUK APPROVAL BPH
    public function approve($id)
    {
        $letter = Letter::findOrFail($id);
        
        // Bikin logic nomor surat otomatis. 
        // Format contoh: 001/UNDANGAN/LDKS/03/2026
        $nomorSurat = sprintf("%03d/%s/LDKS/%s/%d", 
            $letter->id, 
            strtoupper($letter->type), 
            date('m'), // Bisa diganti romawi kalau mau
            date('Y')
        );

        $letter->update([
            'status' => 'approved',
            'letter_number' => $nomorSurat,
            'approved_by' => auth()->id()
        ]);

        return redirect()->route('admin.e-persuratan.index')
                         ->with('success', 'Surat berhasil di-approve & Nomor E-Sign ter-generate!');
    }

    public function show($id)
    {
    $letter = Letter::with(['creator', 'approver'])->findOrFail($id);
    return view('admin-page.e-persuratan.show', compact('letter'));
    }
}