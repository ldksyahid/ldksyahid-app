{{--
    Renders a single form field for the public form.
    Variable: $field (MsFormField instance)
--}}
@php
    $fieldName = 'field_' . $field->formFieldID;
    $fieldID   = 'f_' . $field->formFieldID;
    $oldValue  = old($fieldName);
    $isError   = $errors->has($fieldName);
    $classes   = 'form-control' . ($isError ? ' is-invalid' : '');

    // Icon mapping for field type labels
    $fieldIconMap = [
        'short_text' => 'fa-font',
        'long_text'  => 'fa-align-left',
        'email'      => 'fa-envelope',
        'number'     => 'fa-hashtag',
        'phone'      => 'fa-phone',
        'url'        => 'fa-link',
        'date'       => 'fa-calendar',
        'time'       => 'fa-clock',
        'datetime'   => 'fa-calendar-alt',
        'dropdown'   => 'fa-chevron-down',
        'radio'      => 'fa-dot-circle',
        'checkbox'   => 'fa-check-square',
        'file'       => 'fa-file-upload',
        'image'      => 'fa-image',
    ];
    $fieldIcon = $fieldIconMap[$field->fieldType] ?? null;
@endphp

@switch($field->fieldType)

{{-- ===== SECTION BREAK ===== --}}
@case('section_break')
    <div class="form-field-wrap">
        @if($field->label)
        <div class="section-break-title">
            <i class="fas fa-grip-lines me-2" style="color:#00a79d;font-size:.85em;"></i>
            {{ $field->label }}
        </div>
        @endif
        @if($field->helpText)
        <div class="section-break-desc">{{ $field->helpText }}</div>
        @endif
    </div>
    @break

{{-- ===== PARAGRAPH (display only) ===== --}}
@case('paragraph')
    <div class="form-field-wrap">
        <p style="font-size:.9rem;color:var(--bs-body-color,#374151);margin-bottom:.5rem;">
            {{ $field->label }}
        </p>
        @if($field->helpText)
        <p class="form-field-help">{{ $field->helpText }}</p>
        @endif
    </div>
    @break

{{-- ===== SHORT TEXT / PHONE / URL ===== --}}
@case('short_text')
@case('phone')
@case('url')
    <div class="form-field-wrap auth-input-wrap">
        <label class="form-field-label" for="{{ $fieldID }}">
            @if($fieldIcon)<i class="fas {{ $fieldIcon }}" style="color:#00a79d;font-size:.8em;opacity:.9;margin-right:.3rem;"></i>@endif
            {{ $field->label }}
            @if($field->isRequired) <span class="form-field-required">*</span> @endif
        </label>
        <input
            type="{{ $field->fieldType === 'phone' ? 'tel' : ($field->fieldType === 'url' ? 'url' : 'text') }}"
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="{{ $classes }}"
            placeholder="{{ $field->placeholder ?? '' }}"
            value="{{ $oldValue ?? $field->defaultValue ?? '' }}"
            {{ $field->isRequired ? 'required' : '' }}
            maxlength="500"
        >
        @if($field->helpText)
        <p class="form-field-help">{{ $field->helpText }}</p>
        @endif
        @error($fieldName)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @break

{{-- ===== EMAIL (system field uses auth floating label; custom uses standard) ===== --}}
@case('email')
    <div class="form-field-wrap auth-input-wrap">
        @if($field->isSystemField)
            {{-- Auth-style floating label with icon --}}
            <div class="form-floating">
                <input
                    type="email"
                    class="form-control has-icon {{ $isError ? 'is-invalid' : '' }}"
                    id="{{ $fieldID }}"
                    name="{{ $fieldName }}"
                    placeholder="name@example.com"
                    value="{{ $oldValue ?? '' }}"
                    required autocomplete="email"
                >
                <label for="{{ $fieldID }}" class="has-icon">
                    {{ $field->label }}
                    <span class="form-field-required">*</span>
                </label>
                <i class="fas fa-envelope auth-input-icon"></i>
            </div>
        @else
            <label class="form-field-label" for="{{ $fieldID }}">
                <i class="fas fa-envelope" style="color:#00a79d;font-size:.8em;opacity:.9;margin-right:.3rem;"></i>
                {{ $field->label }}
                @if($field->isRequired) <span class="form-field-required">*</span> @endif
            </label>
            <input type="email" id="{{ $fieldID }}" name="{{ $fieldName }}"
                   class="{{ $classes }}" placeholder="{{ $field->placeholder ?? 'name@example.com' }}"
                   value="{{ $oldValue ?? '' }}"
                   {{ $field->isRequired ? 'required' : '' }} maxlength="255">
        @endif

        @if($field->helpText && !$field->isSystemField)
        <p class="form-field-help">{{ $field->helpText }}</p>
        @elseif($field->isSystemField)
        <p class="form-field-help">A confirmation email will be sent to this address.</p>
        @endif

        @error($fieldName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    @break

{{-- ===== NUMBER ===== --}}
@case('number')
    <div class="form-field-wrap auth-input-wrap">
        <label class="form-field-label" for="{{ $fieldID }}">
            @if($fieldIcon)<i class="fas {{ $fieldIcon }}" style="color:#00a79d;font-size:.8em;opacity:.9;margin-right:.3rem;"></i>@endif
            {{ $field->label }}
            @if($field->isRequired) <span class="form-field-required">*</span> @endif
        </label>
        <input
            type="number"
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="{{ $classes }}"
            placeholder="{{ $field->placeholder ?? '' }}"
            value="{{ $oldValue ?? $field->defaultValue ?? '' }}"
            {{ $field->isRequired ? 'required' : '' }}
            @if(!empty($field->validation['min'])) min="{{ $field->validation['min'] }}" @endif
            @if(!empty($field->validation['max'])) max="{{ $field->validation['max'] }}" @endif
        >
        @if($field->helpText) <p class="form-field-help">{{ $field->helpText }}</p> @endif
        @error($fieldName) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    @break

{{-- ===== LONG TEXT ===== --}}
@case('long_text')
    <div class="form-field-wrap">
        <label class="form-field-label" for="{{ $fieldID }}">
            @if($fieldIcon)<i class="fas {{ $fieldIcon }}" style="color:#00a79d;font-size:.8em;opacity:.9;margin-right:.3rem;"></i>@endif
            {{ $field->label }}
            @if($field->isRequired) <span class="form-field-required">*</span> @endif
        </label>
        <textarea
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="{{ $classes }}"
            rows="4"
            placeholder="{{ $field->placeholder ?? '' }}"
            {{ $field->isRequired ? 'required' : '' }}
        >{{ $oldValue ?? $field->defaultValue ?? '' }}</textarea>
        @if($field->helpText) <p class="form-field-help">{{ $field->helpText }}</p> @endif
        @error($fieldName) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    @break

{{-- ===== DATE / TIME / DATETIME ===== --}}
@case('date')
@case('time')
@case('datetime')
    <div class="form-field-wrap auth-input-wrap">
        <label class="form-field-label" for="{{ $fieldID }}">
            @if($fieldIcon)<i class="fas {{ $fieldIcon }}" style="color:#00a79d;font-size:.8em;opacity:.9;margin-right:.3rem;"></i>@endif
            {{ $field->label }}
            @if($field->isRequired) <span class="form-field-required">*</span> @endif
        </label>
        <input
            type="{{ $field->fieldType === 'datetime' ? 'datetime-local' : $field->fieldType }}"
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="{{ $classes }}"
            value="{{ $oldValue ?? $field->defaultValue ?? '' }}"
            {{ $field->isRequired ? 'required' : '' }}
        >
        @if($field->helpText) <p class="form-field-help">{{ $field->helpText }}</p> @endif
        @error($fieldName) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    @break

{{-- ===== DROPDOWN ===== --}}
@case('dropdown')
    <div class="form-field-wrap auth-input-wrap">
        <label class="form-field-label" for="{{ $fieldID }}">
            @if($fieldIcon)<i class="fas {{ $fieldIcon }}" style="color:#00a79d;font-size:.8em;opacity:.9;margin-right:.3rem;"></i>@endif
            {{ $field->label }}
            @if($field->isRequired) <span class="form-field-required">*</span> @endif
        </label>
        <select id="{{ $fieldID }}" name="{{ $fieldName }}"
                class="form-select {{ $isError ? 'is-invalid' : '' }}"
                {{ $field->isRequired ? 'required' : '' }}>
            <option value="">-- Select --</option>
            @foreach($field->options ?? [] as $option)
            <option value="{{ $option['value'] }}"
                    {{ $oldValue == $option['value'] ? 'selected' : '' }}>
                {{ $option['label'] }}
            </option>
            @endforeach
        </select>
        @if($field->helpText) <p class="form-field-help">{{ $field->helpText }}</p> @endif
        @error($fieldName) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    @break

{{-- ===== RADIO ===== --}}
@case('radio')
    <div class="form-field-wrap">
        <fieldset>
            <legend class="form-field-label">
                @if($fieldIcon)<i class="fas {{ $fieldIcon }}" style="color:#00a79d;font-size:.8em;opacity:.9;margin-right:.3rem;"></i>@endif
                {{ $field->label }}
                @if($field->isRequired) <span class="form-field-required">*</span> @endif
            </legend>
            @foreach($field->options ?? [] as $i => $option)
            <div class="form-check">
                <input class="form-check-input {{ $isError ? 'is-invalid' : '' }}"
                       type="radio" name="{{ $fieldName }}"
                       id="{{ $fieldID }}_{{ $i }}"
                       value="{{ $option['value'] }}"
                       {{ $oldValue == $option['value'] ? 'checked' : '' }}
                       {{ $field->isRequired ? 'required' : '' }}>
                <label class="form-check-label" for="{{ $fieldID }}_{{ $i }}">
                    {{ $option['label'] }}
                </label>
            </div>
            @endforeach
            @if($field->helpText) <p class="form-field-help">{{ $field->helpText }}</p> @endif
            @error($fieldName) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </fieldset>
    </div>
    @break

{{-- ===== CHECKBOX ===== --}}
@case('checkbox')
    <div class="form-field-wrap">
        <fieldset>
            <legend class="form-field-label">
                @if($fieldIcon)<i class="fas {{ $fieldIcon }}" style="color:#00a79d;font-size:.8em;opacity:.9;margin-right:.3rem;"></i>@endif
                {{ $field->label }}
                @if($field->isRequired) <span class="form-field-required">*</span> @endif
            </legend>
            @foreach($field->options ?? [] as $i => $option)
            <div class="form-check">
                <input class="form-check-input {{ $isError ? 'is-invalid' : '' }}"
                       type="checkbox" name="{{ $fieldName }}[]"
                       id="{{ $fieldID }}_{{ $i }}"
                       value="{{ $option['value'] }}"
                       {{ is_array($oldValue) && in_array($option['value'], $oldValue) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldID }}_{{ $i }}">
                    {{ $option['label'] }}
                </label>
            </div>
            @endforeach
            @if($field->helpText) <p class="form-field-help">{{ $field->helpText }}</p> @endif
            @error($fieldName) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </fieldset>
    </div>
    @break

{{-- ===== FILE / IMAGE ===== --}}
@case('file')
@case('image')
    <div class="form-field-wrap">
        <label class="form-field-label">
            @if($fieldIcon)<i class="fas {{ $fieldIcon }}" style="color:#00a79d;font-size:.8em;opacity:.9;margin-right:.3rem;"></i>@endif
            {{ $field->label }}
            @if($field->isRequired) <span class="form-field-required">*</span> @endif
        </label>

        <div class="file-upload-area {{ $isError ? 'border-danger' : '' }}">
            <input type="file" id="{{ $fieldID }}" name="{{ $fieldName }}"
                   {{ $field->isRequired ? 'required' : '' }}
                   @if($field->fieldType === 'image') accept="image/*" @endif
                   @if(!empty($field->validation['acceptedTypes']))
                       accept=".{{ implode(',.', (array) $field->validation['acceptedTypes']) }}"
                   @endif>
            <div>
                <i class="fas fa-{{ $field->fieldType === 'image' ? 'image' : 'cloud-upload-alt' }} fa-2x mb-2"
                   style="color:#00a79d;"></i>
            </div>
            <div style="font-size:.875rem;font-weight:600;color:var(--bs-body-color,#374151);">Click or drag file here</div>
            @if(!empty($field->validation['acceptedTypes']))
            <div style="font-size:.75rem;color:var(--bs-secondary-color,#9ca3af);margin-top:.25rem;">
                Format: {{ implode(', ', (array) $field->validation['acceptedTypes']) }}
            </div>
            @endif
            @if(!empty($field->validation['maxSizeKB']))
            <div style="font-size:.75rem;color:var(--bs-secondary-color,#9ca3af);">
                Max: {{ number_format($field->validation['maxSizeKB'] / 1024, 1) }} MB
            </div>
            @endif
            <div class="file-upload-name">No file selected</div>
        </div>

        @if($field->helpText) <p class="form-field-help">{{ $field->helpText }}</p> @endif
        @error($fieldName) <div class="text-danger d-block" style="font-size:.8rem;margin-top:.25rem;">{{ $message }}</div> @enderror
    </div>
    @break

{{-- ===== FALLBACK ===== --}}
@default
    <div class="form-field-wrap">
        <label class="form-field-label">{{ $field->label }}</label>
        <input type="text" name="{{ $fieldName }}" class="{{ $classes }}"
               placeholder="{{ $field->placeholder ?? '' }}">
    </div>

@endswitch
