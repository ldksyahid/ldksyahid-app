{{--
    Reusable field card for the form builder drop zone.
    Variables: $field (MsFormField)
--}}
<div class="field-card {{ $field->isSystemField ? 'is-system' : '' }}"
     data-field-id="{{ $field->formFieldID }}"
     data-label="{{ $field->label }}"
     data-placeholder="{{ $field->placeholder ?? '' }}"
     data-help-text="{{ $field->helpText ?? '' }}"
     data-is-required="{{ $field->isRequired ? '1' : '0' }}">

    {{-- Drag handle (hidden for system fields) --}}
    @if(!$field->isSystemField)
    <span class="drag-handle" title="Drag untuk mengubah urutan">
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
                    @case('section_break') fa-minus @break
                    @case('paragraph')     fa-paragraph @break
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
        <button type="button" class="btn-del" title="Hapus field"
                onclick="removeField(this)">
            <i class="fa fa-trash"></i>
        </button>
        @endif
    </div>

</div>
