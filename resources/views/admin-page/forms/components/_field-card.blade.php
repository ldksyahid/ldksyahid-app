{{--
    Reusable field card for the form builder drop zone.
    Variables: $field (MsFormField)
--}}
@php
    $isSectionBreak = $field->fieldType === 'section_break';
    $isHeaderImage  = $field->fieldType === 'header_image';
    $hasRouting     = in_array($field->fieldType, ['radio', 'dropdown']) &&
                      ($field->fieldConfig['sectionRouting']['enabled'] ?? false);
@endphp

<div class="field-card {{ $isHeaderImage ? 'field-card--header-image' : ($isSectionBreak ? 'field-card--section-break' : '') }} {{ $field->isSystemField ? 'is-system' : '' }}"
     data-field-id="{{ $field->formFieldID }}"
     data-field-type="{{ $field->fieldType }}"
     data-label="{{ $field->label }}"
     data-placeholder="{{ $field->placeholder ?? '' }}"
     data-help-text="{{ $field->helpText ?? '' }}"
     data-is-required="{{ $field->isRequired ? '1' : '0' }}"
     data-options="{{ json_encode($field->options ?? []) }}"
     data-validation="{{ json_encode($field->validation ?? []) }}"
     data-field-config="{{ json_encode($field->fieldConfig ?? []) }}">

@if($isHeaderImage)
    {{-- ===== HEADER IMAGE: pinned banner card ===== --}}
    <div class="header-img-card-inner">
        @if($field->helpText)
        <img src="{{ $field->helpText }}" alt="Header Image" class="header-img-thumb">
        @else
        <div class="header-img-placeholder"><i class="fa fa-image me-2"></i>No image uploaded yet</div>
        @endif
        <div class="header-img-badge">
            <i class="fa fa-thumbtack me-1"></i>Header Banner · Pinned to top
        </div>
    </div>
    <div class="field-card-actions">
        <button type="button" title="Replace header image" onclick="openEditModal(this)">
            <i class="fa fa-edit"></i>
        </button>
        <button type="button" class="btn-del" title="Remove header image" onclick="removeField(this)">
            <i class="fa fa-trash"></i>
        </button>
    </div>

@elseif($isSectionBreak)
    {{-- ===== SECTION BREAK: visual divider card ===== --}}
    @if(!$field->isSystemField)
    <span class="drag-handle" title="Drag to reorder">
        <i class="fas fa-grip-vertical"></i>
    </span>
    @else
    <span style="width:18px;"></span>
    @endif

    <div class="field-card-body section-break-body">
        <div class="section-break-rule"></div>
        <div class="section-break-label">
            <i class="fa fa-columns me-2"></i>{{ $field->label ?: 'New Section' }}
        </div>
        <div class="section-break-rule"></div>
    </div>

    <div class="field-card-actions">
        <button type="button" title="Edit section title" onclick="openEditModal(this)">
            <i class="fa fa-edit"></i>
        </button>
        @if(!$field->isSystemField)
        <button type="button" class="btn-del" title="Remove section" onclick="removeField(this)">
            <i class="fa fa-trash"></i>
        </button>
        @endif
    </div>

@else
    {{-- ===== REGULAR FIELD CARD ===== --}}

    {{-- Drag handle (hidden for system fields) --}}
    @if(!$field->isSystemField)
    <span class="drag-handle" title="Drag to reorder">
        <i class="fas fa-grip-vertical"></i>
    </span>
    @else
    <span style="width:18px;"></span>
    @endif

    {{-- Field info --}}
    <div class="field-card-body">
        <div class="field-card-label">
            {{-- Field type icon --}}
            <i class="fa fa-sm
                @switch($field->fieldType)
                    @case('email')         fa-envelope @break
                    @case('short_text')    fa-font @break
                    @case('long_text')     fa-align-left @break
                    @case('number')        fa-hashtag @break
                    @case('phone')         fa-phone @break
                    @case('url')           fa-link @break
                    @case('date')          fa-calendar @break
                    @case('time')          fa-clock @break
                    @case('datetime')      fa-calendar-alt @break
                    @case('dropdown')      fa-chevron-circle-down @break
                    @case('radio')         fa-dot-circle @break
                    @case('checkbox')      fa-check-square @break
                    @case('file')          fa-file-upload @break
                    @case('image')         fa-image @break
                    @case('paragraph')     fa-paragraph @break
                    @case('linear_scale')  fa-sliders-h @break
                    @case('rating')        fa-star @break
                    @default               fa-question-circle
                @endswitch
                me-1 text-muted"></i>

            {{ $field->label }}

            @if($field->isRequired)
            <span class="field-card-required">*</span>
            @endif

            @if($field->isSystemField)
            <span class="field-card-system-badge">
                <i class="fa fa-lock fa-xs me-1"></i>System
            </span>
            @endif

            @if($hasRouting)
            <span class="field-card-routing-badge">
                <i class="fas fa-code-branch fa-xs me-1"></i>Routing
            </span>
            @endif
        </div>

        <div class="field-card-type">
            {{ str_replace('_', ' ', ucfirst($field->fieldType)) }}
            @if($field->helpText)
            &nbsp;· {{ Str::limit($field->helpText, 50) }}
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="field-card-actions">
        <button type="button" title="Edit field" onclick="openEditModal(this)">
            <i class="fa fa-edit"></i>
        </button>

        @if(!$field->isSystemField)
        <button type="button" class="btn-del" title="Remove field" onclick="removeField(this)">
            <i class="fa fa-trash"></i>
        </button>
        @endif
    </div>

@endif

</div>
