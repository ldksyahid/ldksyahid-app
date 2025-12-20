@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
    $isSuperadmin = LFC::getRoleName(auth()->user()->getRoleNames()) === 'Superadmin';
@endphp

@if ($financeReports->count() > 0)
    @foreach ($financeReports as $key => $report)
    <tr>
        <td>
            <input type="checkbox" name="ids[]" value="{{ $report->financeReportID }}" {{ $isSuperadmin ? '' : 'disabled' }}>
        </td>
        <th scope="row">{{ $financeReports->firstItem() + $key }}</th>
        <td class="text-center">{{ \Carbon\Carbon::parse($report->createdDate)->isoFormat('DD MMMM YYYY') }}</td>
        <td class="text-center">{{ $report->fileName }}</td>
        <td class="text-center">
            <span class="badge bg-primary">{{ $report->ldk->ldkTag ?? 'N/A' }}</span>
        </td>
        <td class="text-center">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.finance-report.show', $report->financeReportID) }}"
                   class="btn btn-sm btn-custom-primary" title="View">
                    <i class="fa fa-eye" style="color: white;"></i>
                </a>
                <a href="{{ route('admin.finance-report.edit', $report->financeReportID) }}"
                   class="btn btn-sm btn-custom-primary" title="Edit">
                    <i class="fa fa-edit" style="color: white;"></i>
                </a>
                <button type="button"
                    class="btn btn-sm btn-custom-primary delete-report-btn"
                    data-id="{{ $report->financeReportID }}"
                    title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="text-center py-4">
            <div class="d-flex flex-column align-items-center">
                <i class="fa fa-file-invoice-dollar fa-2x mb-2 text-muted"></i>
                <span class="text-muted">No finance reports found</span>
            </div>
        </td>
    </tr>
@endif
