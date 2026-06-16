{{--
    Reusable Admin Index Table Component

    This component renders table rows based on configuration.
    All configuration is passed from the parent view/controller.

    Usage:
    <x-admin-index.index-table
        :items="$items"
        :tableConfig="$tableConfig"
    />

    Table Config Structure:
    $tableConfig = [
        'idKey' => 'id',                    // Primary key field
        'emptyMessage' => 'No data found',  // Message when no data
        'emptyIcon' => 'fa-file',           // Icon for empty state
        'colspan' => 6,                     // Column span for empty state
        'columns' => [
            [
                'key' => 'field_name',
                'type' => 'text|date|datetime|badge|link|copy-button|shortlink|relation|custom',
                'class' => 'text-center',   // Optional CSS class
                'dateFormat' => 'DD MMMM YYYY', // For date type
                'badgeClass' => 'bg-primary',   // For badge type
                'route' => 'route.name',        // For link type
                'routeKey' => 'id',             // Route parameter key
                'target' => '_blank',           // For link type
                'relationKey' => 'relation.field', // For relation type
                'copyWithBaseUrl' => true,      // For copy-button/shortlink type
                'fallback' => '-',              // Fallback value if null
            ],
        ],
        'actions' => [
            'view' => [
                'enabled' => true,
                'route' => 'admin.resource.show',
                'routeKey' => 'id',
            ],
            'edit' => [
                'enabled' => true,
                'type' => 'link|modal',         // 'link' for page, 'modal' for modal
                'route' => 'admin.resource.edit', // For link type
                'routeKey' => 'id',
                'modalData' => ['id', 'name'],  // Fields to pass to modal
            ],
            'delete' => [
                'enabled' => true,
                'class' => 'delete-btn',
            ],
        ],
    ];
--}}

@php
    // $isSuperadmin is automatically available via View Composer
    $isSuperadmin = $isSuperadmin ?? false;

    // Ensure tableConfig exists
    $tableConfig = $tableConfig ?? [];

    // Extract config with defaults
    $idKey = $tableConfig['idKey'] ?? 'id';
    $emptyMessage = $tableConfig['emptyMessage'] ?? 'No data found';
    $emptyIcon = $tableConfig['emptyIcon'] ?? 'fa-file';
    $colspan = $tableConfig['colspan'] ?? 6;
    $columns = $tableConfig['columns'] ?? [];
    $actions = $tableConfig['actions'] ?? [];
    $deleteOwnerField     = $actions['delete']['ownerField'] ?? null;
    $deleteOwnerCompareBy = $actions['delete']['ownerCompareField'] ?? 'email';
    $currentUser          = auth()->user();
@endphp

@if ($items->count() > 0)
    @foreach ($items as $key => $item)
    <tr>
        {{-- Checkbox Column --}}
        <td>
            @php $isItemOwner = $deleteOwnerField && $currentUser && $item->{$deleteOwnerField} === $currentUser->{$deleteOwnerCompareBy}; @endphp
            <input type="checkbox" name="ids[]" value="{{ $item->{$idKey} }}" {{ (!$isSuperadmin && !$isItemOwner) ? 'disabled' : '' }}>
        </td>

        {{-- Row Number --}}
        <th scope="row">{{ $items->firstItem() + $key }}</th>

        {{-- Dynamic Columns --}}
        @foreach ($columns as $col)
            @php
                $colClass = $col['class'] ?? 'text-center';
                $colType = $col['type'] ?? 'text';
                $colKey = $col['key'] ?? '';
                $fallback = $col['fallback'] ?? '-';

                // Get value (supports dot notation for relations)
                $value = data_get($item, $colKey, $fallback);
            @endphp

            <td class="{{ $colClass }}">
                @switch($colType)
                    @case('text')
                        {{ $value ?: $fallback }}
                        @break

                    @case('date')
                        @if($value && $value !== $fallback && strtotime($value) !== false)
                            {{ \Carbon\Carbon::parse($value)->isoFormat($col['dateFormat'] ?? 'DD MMMM YYYY') }}
                        @else
                            {{ $fallback }}
                        @endif
                        @break

                    @case('datetime')
                        @if($value && $value !== $fallback && strtotime($value) !== false)
                            {{ \Carbon\Carbon::parse($value)->isoFormat($col['dateFormat'] ?? 'DD MMMM YYYY') }} ({{ \Carbon\Carbon::parse($value)->format($col['timeFormat'] ?? 'H:i T') }})
                        @else
                            {{ $fallback }}
                        @endif
                        @break

                    @case('badge')
                        @php
                            $badgeClass = $col['badgeClass'] ?? 'bg-primary';
                            if (isset($col['badgeMap']) && isset($col['badgeMap'][$value])) {
                                $badgeClass = $col['badgeMap'][$value];
                            } elseif (isset($col['badgeMap']) && isset($col['badgeDefault'])) {
                                $badgeClass = $col['badgeDefault'];
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $value ?: $fallback }}</span>
                        @break

                    @case('link')
                        @if($value)
                            <a href="{{ $value }}" target="{{ $col['target'] ?? '_blank' }}">{{ $value }}</a>
                        @else
                            {{ $fallback }}
                        @endif
                        @break

                    @case('copy-button')
                        @if($value)
                            @php
                                $fullUrl = ($col['copyWithBaseUrl'] ?? false) ? url(($col['linkPrefix'] ?? '') . $value) : (($col['linkPrefix'] ?? '') . $value);
                            @endphp
                            <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $value }}', {{ ($col['copyWithBaseUrl'] ?? false) ? 'true' : 'false' }})">
                                <i class="fa fa-copy small"></i>
                            </button>
                            @if(isset($col['showAsLink']) && $col['showAsLink'])
                                <a href="{{ $fullUrl }}" target="_blank">{{ $fullUrl }}</a>
                            @else
                                {{ $value }}
                            @endif
                        @else
                            {{ $fallback }}
                        @endif
                        @break

                    @case('shortlink')
                        @php
                            $urlKey = data_get($item, $col['urlKeyField'] ?? 'url_key');
                            $shortUrl = url($urlKey);
                            $displayUrl = str_replace('www.', '', parse_url($shortUrl, PHP_URL_HOST)) . parse_url($shortUrl, PHP_URL_PATH);
                        @endphp
                        <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $urlKey }}')">
                            <i class="fa fa-copy small"></i>
                        </button>
                        <a href="{{ $shortUrl }}" target="_blank">{{ $displayUrl }}</a>
                        @break

                    @case('destination-link')
                        @if($value)
                            <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $value }}', false)">
                                <i class="fa fa-copy small"></i>
                            </button>
                            <a href="{{ $value }}" target="_blank">{{ $value }}</a>
                        @else
                            {{ $fallback }}
                        @endif
                        @break

                    @case('url-key')
                        <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $value }}', false)">
                            <i class="fa fa-copy small"></i>
                        </button>
                        {{ $value }}
                        @break

                    @case('count')
                        {{ $item->{$col['countRelation'] ?? $colKey}->count() }}
                        @break

                    @case('relation')
                        @php
                            $relationValue = data_get($item, $col['relationKey'] ?? $colKey, $fallback);
                        @endphp
                        {{ $relationValue ?: $fallback }}
                        @break

                    @case('email-with-google')
                        <div class="d-flex align-items-center gap-1" style="min-width:0;">
                            <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;min-width:0;flex:1;"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $value ?: $fallback }}">{{ $value ?: $fallback }}</span>
                            @if(data_get($item, 'googleID'))
                                <svg style="flex-shrink:0;" width="13" height="13" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" title="Google account linked">
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                </svg>
                            @endif
                        </div>
                        @break

                    @case('verification-badge')
                        @php
                            // Get the actual value without fallback for proper null check
                            $actualValue = data_get($item, $colKey);
                        @endphp
                        @if($actualValue)
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-secondary">Not Verified</span>
                        @endif
                        @break

                    @case('role-badge')
                        @php
                            $roleClasses = [
                                'Superadmin' => 'bg-danger',
                                'HelperAdmin' => 'bg-warning',
                                'HelperCelsyahid' => 'bg-success',
                                'HelperEventMart' => 'bg-indigo',
                                'HelperSPAM' => 'bg-info',
                                'HelperMedia' => 'bg-dark',
                                'HelperLetter' => 'bg-secondary',
                                'User' => 'bg-primary',
                            ];
                            $roleClass = $roleClasses[$value] ?? 'bg-primary';
                        @endphp
                        <span class="badge {{ $roleClass }}" @if($value === 'HelperEventMart') style="background-color: #5352ed;" @endif>{{ $value ?: 'User' }}</span>
                        @break

                    @default
                        {{ $value ?: $fallback }}
                @endswitch
            </td>
        @endforeach

        {{-- Actions Column --}}
        <td class="text-center">
            <div class="btn-group" role="group">
                {{-- View Button --}}
                @if(isset($actions['view']) && $actions['view']['enabled'])
                    <a href="{{ route($actions['view']['route'], $item->{$actions['view']['routeKey'] ?? $idKey}) }}"
                       class="btn btn-sm {{ $actions['view']['class'] ?? 'btn-custom-primary' }}" title="View">
                        <i class="fa fa-eye" style="color: white;"></i>
                    </a>
                @endif

                {{-- Edit Button --}}
                @if(isset($actions['edit']) && $actions['edit']['enabled'])
                    @php
                        $isEditProtected     = isset($actions['edit']['protectedId']) && $item->{$idKey} == $actions['edit']['protectedId'];
                        $editOwnerField      = $actions['edit']['ownerField'] ?? null;
                        $editOwnerCompareBy  = $actions['edit']['ownerCompareField'] ?? 'email';
                        $isEditOwnerRestricted = $editOwnerField && $currentUser && $item->{$editOwnerField} !== $currentUser->{$editOwnerCompareBy} && !$isSuperadmin;
                        $editDisabled        = $isEditProtected || $isEditOwnerRestricted;
                        $editTitle           = $isEditProtected ? 'Protected' : ($isEditOwnerRestricted ? 'Only the creator can edit this' : 'Edit');
                    @endphp
                    @if(($actions['edit']['type'] ?? 'link') === 'modal')
                        <button type="button"
                            class="btn btn-sm {{ $actions['edit']['class'] ?? 'btn-primary' }} edit-btn"
                            @foreach($actions['edit']['modalData'] ?? [] as $dataKey => $dataField)
                                data-{{ $dataKey }}="{{ data_get($item, $dataField) }}"
                            @endforeach
                            title="{{ $editTitle }}"
                            {{ $editDisabled ? 'disabled' : '' }}>
                            <i class="fa fa-edit"></i>
                        </button>
                    @else
                        @if($editDisabled)
                            <button type="button" class="btn btn-sm {{ $actions['edit']['class'] ?? 'btn-custom-primary' }}" disabled title="{{ $editTitle }}">
                                <i class="fa fa-edit" style="color: white;"></i>
                            </button>
                        @else
                            <a href="{{ route($actions['edit']['route'], $item->{$actions['edit']['routeKey'] ?? $idKey}) }}"
                               class="btn btn-sm {{ $actions['edit']['class'] ?? 'btn-custom-primary' }}" title="Edit">
                                <i class="fa fa-edit" style="color: white;"></i>
                            </a>
                        @endif
                    @endif
                @endif

                {{-- Delete Button --}}
                @if(isset($actions['delete']) && $actions['delete']['enabled'])
                    @php
                        $isDeleteProtected       = isset($actions['delete']['protectedId']) && $item->{$idKey} == $actions['delete']['protectedId'];
                        $isSuperadminOnly        = ($actions['delete']['superadminOnly'] ?? false) && !$isSuperadmin;
                        $isOwnerRestricted       = $deleteOwnerField && $currentUser && $item->{$deleteOwnerField} !== $currentUser->{$deleteOwnerCompareBy} && !$isSuperadmin;
                        $disabledCondField       = $actions['delete']['disabledConditionField'] ?? null;
                        $isConditionDisabled     = $disabledCondField && !empty($item->{$disabledCondField});
                        $conditionDisabledTitle  = $actions['delete']['disabledConditionTitle'] ?? 'Cannot delete this item';
                        $deleteTitle             = $isDeleteProtected ? 'Protected'
                            : ($isOwnerRestricted ? 'Only the creator can delete this'
                            : ($isConditionDisabled ? $conditionDisabledTitle : 'Delete'));
                        $isDeleteDisabled        = $isDeleteProtected || $isSuperadminOnly || $isOwnerRestricted || $isConditionDisabled;
                    @endphp
                    <button type="button"
                        class="btn btn-sm {{ $actions['delete']['class'] ?? 'btn-custom-primary' }} {{ $actions['delete']['btnClass'] ?? 'delete-btn' }} delete-action-btn"
                        data-id="{{ $item->{$idKey} }}"
                        title="{{ $deleteTitle }}"
                        {{ $isDeleteDisabled ? 'disabled' : '' }}>
                        <i class="fa fa-trash"></i>
                    </button>
                @endif

                {{-- Custom Action Buttons --}}
                @if(isset($actions['custom']) && is_array($actions['custom']))
                    @foreach($actions['custom'] as $customAction)
                        @if($customAction['enabled'] ?? true)
                            @php
                                $customType           = $customAction['type'] ?? 'link';
                                $customOwnerField     = $customAction['ownerField'] ?? null;
                                $customOwnerCompareBy = $customAction['ownerCompareField'] ?? 'email';
                                $isCustomOwnerRestricted = $customOwnerField && $currentUser && $item->{$customOwnerField} !== $currentUser->{$customOwnerCompareBy} && !$isSuperadmin;
                            @endphp

                            @if($customType === 'status-toggle')
                                {{-- Single slot: route/icon/class change per status value. Button is a direct
                                     child of .btn-group so Bootstrap border-radius rules apply correctly. --}}
                                @php
                                    $toggleFieldVal = $item->{$customAction['field']};
                                    $toggleState    = $customAction['states'][$toggleFieldVal] ?? null;
                                @endphp
                                @if($toggleState && !($toggleState['hidden'] ?? false))
                                    @if($isCustomOwnerRestricted)
                                        <button type="button"
                                                class="btn btn-sm {{ $toggleState['class'] ?? 'btn-custom-primary' }}"
                                                title="Only the creator can change the status"
                                                disabled>
                                            <i class="fa {{ $toggleState['icon'] ?? 'fa-link' }}" style="color:white;"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-sm {{ $toggleState['class'] ?? 'btn-custom-primary' }}"
                                                title="{{ $toggleState['title'] ?? '' }}"
                                                data-url="{{ route($toggleState['route'], $item->{$customAction['routeKey'] ?? $idKey}) }}"
                                                data-token="{{ csrf_token() }}"
                                                data-confirm-title="{{ $toggleState['confirm']['title'] ?? ('Confirm ' . ($toggleState['title'] ?? 'Action')) }}"
                                                data-confirm-text="{{ $toggleState['confirm']['text'] ?? 'Are you sure you want to continue?' }}"
                                                data-confirm-btn="{{ $toggleState['confirm']['confirmButtonText'] ?? 'Yes, Continue' }}"
                                                data-success-msg="{{ $toggleState['successMsg'] ?? 'Done!' }}"
                                                onclick="confirmStatusToggle(this)">
                                            <i class="fa {{ $toggleState['icon'] ?? 'fa-link' }}" style="color:white;"></i>
                                        </button>
                                    @endif
                                @endif

                            @elseif($customType === 'post-form')
                                {{-- Conditional POST button, direct child of .btn-group. --}}
                                @php
                                    $showCustomAction = true;
                                    if (isset($customAction['conditionField'], $customAction['conditionValues'])) {
                                        $showCustomAction = in_array($item->{$customAction['conditionField']}, $customAction['conditionValues']);
                                    }
                                @endphp
                                @if($showCustomAction)
                                    @if($isCustomOwnerRestricted)
                                        <button type="button"
                                                class="btn btn-sm {{ $customAction['class'] ?? 'btn-custom-primary' }}"
                                                title="Only the creator can perform this action"
                                                disabled>
                                            <i class="fa {{ $customAction['icon'] ?? 'fa-link' }}" style="color:white;"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-sm {{ $customAction['class'] ?? 'btn-custom-primary' }}"
                                                title="{{ $customAction['title'] ?? '' }}"
                                                onclick="submitPostAction('{{ route($customAction['route'], $item->{$customAction['routeKey'] ?? $idKey}) }}','{{ csrf_token() }}')">
                                            <i class="fa {{ $customAction['icon'] ?? 'fa-link' }}" style="color:white;"></i>
                                        </button>
                                    @endif
                                @endif

                            @else
                                {{-- Default: anchor link --}}
                                @php
                                    $customUrl = '';
                                    if (isset($customAction['urlBuilder'])) {
                                        $customUrl = $customAction['urlBuilder']($item);
                                    } elseif (isset($customAction['route'])) {
                                        $customUrl = route($customAction['route'], $item->{$customAction['routeKey'] ?? $idKey});
                                    }
                                @endphp
                                @if($isCustomOwnerRestricted)
                                    <button type="button"
                                            class="btn btn-sm {{ $customAction['class'] ?? 'btn-success' }}"
                                            title="Only the creator can access this"
                                            disabled>
                                        <i class="fa {{ $customAction['icon'] ?? 'fa-link' }}" style="color:white;"></i>
                                    </button>
                                @else
                                    <a href="{{ $customUrl }}"
                                       target="{{ $customAction['target'] ?? '_self' }}"
                                       class="btn btn-sm {{ $customAction['class'] ?? 'btn-success' }}"
                                       title="{{ $customAction['title'] ?? '' }}">
                                        <i class="fa {{ $customAction['icon'] ?? 'fa-link' }}" style="color: white;"></i>
                                    </a>
                                @endif
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="{{ $colspan }}" class="text-center py-4">
            <div class="d-flex flex-column align-items-center">
                <i class="fa {{ $emptyIcon }} fa-2x mb-2 text-muted"></i>
                <span class="text-muted">{{ $emptyMessage }}</span>
            </div>
        </td>
    </tr>
@endif

@once
<script>
// Used by post-form type (direct submit, navigates away)
function submitPostAction(url, token) {
    const f = document.createElement('form');
    f.method = 'POST';
    f.action = url;
    const t = document.createElement('input');
    t.type = 'hidden'; t.name = '_token'; t.value = token;
    f.appendChild(t);
    document.body.appendChild(f);
    f.submit();
}

// Used by status-toggle type (AJAX, stays on page)
function confirmStatusToggle(btn) {
    const url        = btn.dataset.url;
    const token      = btn.dataset.token;
    const title      = btn.dataset.confirmTitle;
    const text       = btn.dataset.confirmText;
    const confirmBtn = btn.dataset.confirmBtn;
    const successMsg = btn.dataset.successMsg;

    Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#00a79d',
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmBtn,
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (!result.isConfirmed) return;

        const originalHtml = btn.innerHTML;
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN':     token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            btn.disabled  = false;
            btn.innerHTML = originalHtml;

            if (data.success !== false) {
                if (window.Toast) {
                    window.Toast.fire({ icon: 'success', title: successMsg });
                }
                if (typeof window.loadData === 'function') {
                    window.loadData();
                } else {
                    location.reload();
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Something went wrong.' });
            }
        })
        .catch(err => {
            btn.disabled  = false;
            btn.innerHTML = originalHtml;
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
        });
    });
}
</script>
@endonce
