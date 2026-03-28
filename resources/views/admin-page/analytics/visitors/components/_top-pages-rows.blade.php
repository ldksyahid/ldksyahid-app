@forelse ($items as $row)
<tr>
    <td class="text-muted" style="width:40px;">{{ $items->firstItem() + $loop->index }}</td>
    <td style="max-width:0;">
        <div style="max-width:400px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"
             data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $row->path }}">
            <code style="font-size:.82rem;">{{ $row->path }}</code>
        </div>
    </td>
    <td class="text-end" style="white-space:nowrap;">{{ number_format($row->hits) }}</td>
    <td class="text-end" style="white-space:nowrap;">{{ number_format($row->uniques) }}</td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center text-muted py-4">
        <i class="fas fa-inbox me-2"></i>No data found
    </td>
</tr>
@endforelse
