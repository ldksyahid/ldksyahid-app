@extends('admin-page.template.body')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Manajemen E-Persuratan</h3>
        
        @role('HelperLetter|Superadmin')
        <a href="{{ route('admin.e-persuratan.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-plus me-2"></i> Buat Surat Baru
        </a>
        @endrole
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Surat</th>
                            <th>Perihal</th>
                            <th>Pembuat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($letters as $letter)
    <tr>
        <td>
            @if($letter->letter_number)
                <span class="fw-bold text-success">{{ $letter->letter_number }}</span>
            @else
                <span class="text-muted fst-italic">Menunggu ACC</span>
            @endif
        </td>
        <td>
            <span class="fw-bold">{{ $letter->subject }}</span><br>
            <small class="text-muted">Tujuan: {{ $letter->destination }}</small>
        </td>
        <td>{{ $letter->creator->name ?? 'Staf Kestari' }}</td>
        <td>
            @if($letter->status == 'pending')
                <span class="badge bg-warning text-dark">Pending Approval</span>
            @elseif($letter->status == 'approved')
                <span class="badge bg-success">Approved</span>
            @endif
        </td>
        <td>
            <a href="{{ route('admin.e-persuratan.show', $letter->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
    <i class="fas fa-eye"></i> Detail
</a>

            @role('Superadmin')
                @if($letter->status == 'pending')
                <form action="{{ route('admin.e-persuratan.approve', $letter->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success" title="Approve & E-Sign" onclick="return confirm('Yakin ingin menyetujui surat ini?')">
                        <i class="fas fa-check-circle"></i>
                    </button>
                </form>
                @endif
            @endrole
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center text-muted py-4">
            <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i><br>
            Belum ada data surat.
        </td>
    </tr>
    @endforelse
</tbody>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection