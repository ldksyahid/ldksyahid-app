@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
    $isSuperadmin = LFC::getRoleName(auth()->user()->getRoleNames()) === 'Superadmin';
@endphp

@forelse ($urls as $key => $item)
<tr>
    <td>
        <input type="checkbox" name="ids[]" value="{{ $item->id }}" {{ $isSuperadmin ? '' : 'disabled' }}>
    </td>
    <th scope="row">{{ $urls->firstItem() + $key }}</th>
    <td class="text-center">{{ $item->url_key }}</td>
    <td class="text-center"><a href="{{ $item->destination_url }}" target="_blank">{{ $item->destination_url }}</a></td>
    <td>
        <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $item->url_key }}')">
            <i class="fa fa-copy small"></i>
        </button>
        <a href="{{ url($item->url_key) }}" target="_blank">{{ parse_url(url($item->url_key), PHP_URL_HOST) }}{{ parse_url(url($item->url_key), PHP_URL_PATH) }}</a>
    </td>
    <td class="text-center">{{ $item->visits_count }}</td>
    <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('DD') }} {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('YYYY') }} ({{ \Carbon\Carbon::parse($item->created_at)->format('H:i T') }})</td>
    <td class="text-center">{{ $item->created_by ?? 'Undefined' }}</td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
            <i class="fa fa-edit"></i>
        </button>
        <button type="button" class="btn btn-sm btn-danger" onclick="deleteConfirmationShortlink({{ $item->id }})" {{ $isSuperadmin ? '' : 'disabled' }}>
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>

<div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Shortlink</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="edit-form" data-id="{{ $item->id }}">
                    @csrf
                    <div class="mb-3">
                        <label for="key-{{ $item->id }}" class="form-label">URL Key</label>
                        <input type="text" name="url" value="{{ $item->url_key }}" class="form-control" id="key-{{ $item->id }}" required>
                        <div class="invalid-feedback url-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="destination-{{ $item->id }}" class="form-label">Destination URL</label>
                        <input type="text" name="destination" value="{{ $item->destination_url }}" class="form-control" id="destination-{{ $item->id }}" required>
                        <div class="invalid-feedback destination-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@empty
<tr>
    <td colspan="9" class="text-center">No Shortlink Data</td>
</tr>
@endforelse
