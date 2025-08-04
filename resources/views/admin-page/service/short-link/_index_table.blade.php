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
    <td>
        <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $item->url_key }}', false)">
            <i class="fa fa-copy small"></i>
        </button>
        {{ $item->url_key }}
    </td>
    <td>
        <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $item->destination_url }}', false)">
            <i class="fa fa-copy small"></i>
        </button>
        <a href="{{ $item->destination_url }}" target="_blank">{{ $item->destination_url }}</a>
    </td>
    <td>
        <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $item->url_key }}')">
            <i class="fa fa-copy small"></i>
        </button>
        <a href="{{ url($item->url_key) }}" target="_blank">{{ str_replace('www.', '', parse_url(url($item->url_key), PHP_URL_HOST)) }}{{ parse_url(url($item->url_key), PHP_URL_PATH) }}</a>
    </td>
    <td class="text-center">{{ $item->visits->count() }}</td>
    <td class="text-center">{{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('YYYY') }} ({{ \Carbon\Carbon::parse( $item->created_at )->format('H:i T') }})</td>
    <td class="text-center">{{ $item->created_by ?? 'Undefined' }}</td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="{{ $item->id }}" data-url="{{ $item->url_key }}" data-destination="{{ $item->destination_url }}">
            <i class="fa fa-edit"></i>
        </button>
        <button type="button"
            class="btn btn-sm btn-danger delete-btn"
            data-id="{{ $item->id }}"
            {{ $isSuperadmin ? '' : 'disabled' }}>
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center">No Shortlink Data</td>
</tr>
@endforelse
