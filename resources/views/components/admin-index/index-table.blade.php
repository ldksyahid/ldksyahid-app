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
@endphp

@if ($items->count() > 0)
    @foreach ($items as $key => $item)
    <tr>
        {{-- Checkbox Column --}}
        <td>
            <input type="checkbox" name="ids[]" value="{{ $item->{$idKey} }}" {{ $isSuperadmin ? '' : 'disabled' }}>
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
                        <span class="badge {{ $col['badgeClass'] ?? 'bg-primary' }}">{{ $value ?: $fallback }}</span>
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
                            <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $value }}', {{ ($col['copyWithBaseUrl'] ?? false) ? 'true' : 'false' }})">
                                <i class="fa fa-copy small"></i>
                            </button>
                            @if(isset($col['showAsLink']) && $col['showAsLink'])
                                <a href="{{ $col['linkPrefix'] ?? '' }}{{ $value }}" target="_blank">{{ $value }}</a>
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
                        $isEditProtected = isset($actions['edit']['protectedId']) && $item->{$idKey} == $actions['edit']['protectedId'];
                    @endphp
                    @if(($actions['edit']['type'] ?? 'link') === 'modal')
                        <button type="button"
                            class="btn btn-sm {{ $actions['edit']['class'] ?? 'btn-primary' }} edit-btn"
                            @foreach($actions['edit']['modalData'] ?? [] as $dataKey => $dataField)
                                data-{{ $dataKey }}="{{ data_get($item, $dataField) }}"
                            @endforeach
                            title="Edit"
                            {{ $isEditProtected ? 'disabled' : '' }}>
                            <i class="fa fa-edit"></i>
                        </button>
                    @else
                        @if($isEditProtected)
                            <button type="button" class="btn btn-sm {{ $actions['edit']['class'] ?? 'btn-custom-primary' }}" disabled title="Protected">
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
                        $isDeleteProtected = isset($actions['delete']['protectedId']) && $item->{$idKey} == $actions['delete']['protectedId'];
                        $isSuperadminOnly = ($actions['delete']['superadminOnly'] ?? false) && !$isSuperadmin;
                    @endphp
                    <button type="button"
                        class="btn btn-sm {{ $actions['delete']['class'] ?? 'btn-custom-primary' }} {{ $actions['delete']['btnClass'] ?? 'delete-btn' }} delete-action-btn"
                        data-id="{{ $item->{$idKey} }}"
                        title="{{ $isDeleteProtected ? 'Protected' : 'Delete' }}"
                        {{ $isDeleteProtected || $isSuperadminOnly ? 'disabled' : '' }}>
                        <i class="fa fa-trash"></i>
                    </button>
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
