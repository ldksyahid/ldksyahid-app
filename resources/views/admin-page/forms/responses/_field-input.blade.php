{{--
    Renders one editable field for the Manage Responses edit form.
    Variables: $field (MsFormField), $answers (array formFieldID => raw sheet value), $files (Collection formFieldID => TrFormFile)
    Plain Bootstrap controls on purpose — this is an admin utility screen, not
    the public-facing form, so it doesn't need the fancy custom widgets.
--}}
@php
    $fieldKey = 'field_' . $field->formFieldID;
    $current  = old($fieldKey, $answers[$field->formFieldID] ?? '');
    $isError  = $errors->has($fieldKey);
@endphp

<div class="mb-3">
    <label class="form-label fw-semibold">
        {{ $field->label }}
        @if($field->isRequired)<span class="text-danger">*</span>@endif
        <span class="text-muted fw-normal" style="font-size:.75rem;">({{ str_replace('_', ' ', $field->fieldType) }})</span>
    </label>

    @switch($field->fieldType)

        @case('long_text')
            <textarea name="{{ $fieldKey }}" rows="3" class="form-control {{ $isError ? 'is-invalid' : '' }}">{{ $current }}</textarea>
            @break

        @case('email')
            <input type="email" name="{{ $fieldKey }}" value="{{ $current }}" class="form-control {{ $isError ? 'is-invalid' : '' }}">
            @break

        @case('number')
            <input type="number" name="{{ $fieldKey }}" value="{{ $current }}" class="form-control {{ $isError ? 'is-invalid' : '' }}">
            @break

        @case('phone')
            <input type="tel" name="{{ $fieldKey }}" value="{{ $current }}" class="form-control {{ $isError ? 'is-invalid' : '' }}">
            @break

        @case('url')
            <input type="url" name="{{ $fieldKey }}" value="{{ $current }}" class="form-control {{ $isError ? 'is-invalid' : '' }}">
            @break

        @case('date')
            <input type="date" name="{{ $fieldKey }}" value="{{ $current }}" class="form-control {{ $isError ? 'is-invalid' : '' }}">
            @break

        @case('time')
            <input type="time" name="{{ $fieldKey }}" value="{{ $current }}" class="form-control {{ $isError ? 'is-invalid' : '' }}">
            @break

        @case('datetime')
            <input type="datetime-local" name="{{ $fieldKey }}" value="{{ $current }}" class="form-control {{ $isError ? 'is-invalid' : '' }}">
            @break

        @case('dropdown')
            <select name="{{ $fieldKey }}" class="form-select {{ $isError ? 'is-invalid' : '' }}">
                <option value="">-- Pilih salah satu --</option>
                @foreach($field->options ?? [] as $option)
                <option value="{{ $option['value'] }}" {{ (string) $current === (string) $option['value'] ? 'selected' : '' }}>
                    {{ $option['label'] }}
                </option>
                @endforeach
            </select>
            @break

        @case('radio')
            @foreach($field->options ?? [] as $i => $option)
            <div class="form-check">
                <input class="form-check-input" type="radio" name="{{ $fieldKey }}" id="{{ $fieldKey }}_{{ $i }}"
                       value="{{ $option['value'] }}" {{ (string) $current === (string) $option['value'] ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldKey }}_{{ $i }}">{{ $option['label'] }}</label>
            </div>
            @endforeach
            @break

        @case('checkbox')
            @php
                $checkedValues = array_filter(array_map('trim', explode(',', $current)));
            @endphp
            @foreach($field->options ?? [] as $i => $option)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $fieldKey }}[]" id="{{ $fieldKey }}_{{ $i }}"
                       value="{{ $option['value'] }}" {{ in_array((string) $option['value'], $checkedValues) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldKey }}_{{ $i }}">{{ $option['label'] }}</label>
            </div>
            @endforeach
            @break

        @case('linear_scale')
            @php
                $lsConfig = $field->fieldConfig ?? [];
                $lsMin    = (int) ($lsConfig['minValue'] ?? 1);
                $lsMax    = (int) ($lsConfig['maxValue'] ?? 5);
            @endphp
            <div class="d-flex gap-3 flex-wrap">
                @for($n = $lsMin; $n <= $lsMax; $n++)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="{{ $fieldKey }}" id="{{ $fieldKey }}_{{ $n }}"
                           value="{{ $n }}" {{ (string) $current === (string) $n ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $fieldKey }}_{{ $n }}">{{ $n }}</label>
                </div>
                @endfor
            </div>
            @break

        @case('rating')
            @php
                $rtConfig = $field->fieldConfig ?? [];
                $rtMax    = (int) ($rtConfig['maxRating'] ?? 5);
            @endphp
            <div class="d-flex gap-3 flex-wrap">
                @for($n = 1; $n <= $rtMax; $n++)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="{{ $fieldKey }}" id="{{ $fieldKey }}_{{ $n }}"
                           value="{{ $n }}" {{ (string) $current === (string) $n ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $fieldKey }}_{{ $n }}">{{ $n }} <i class="fas fa-star text-warning"></i></label>
                </div>
                @endfor
            </div>
            @break

        @case('file')
            @php $existingFile = $files[$field->formFieldID] ?? null; @endphp
            @if($existingFile)
            <div class="mb-2">
                <a href="{{ $existingFile->gdriveFileUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-external-link-alt me-1"></i> {{ $existingFile->originalFileName }}
                </a>
            </div>
            @elseif($current === '[file pending]')
            <p class="text-muted mb-2" style="font-size:.8rem;">
                <i class="fa fa-clock me-1"></i> File masih diproses (belum selesai diupload ke Google Drive).
            </p>
            @else
            <p class="text-muted mb-2" style="font-size:.8rem;">Belum ada file.</p>
            @endif
            <input type="file" name="{{ $fieldKey }}" class="form-control {{ $isError ? 'is-invalid' : '' }}">
            <div class="form-text">Kosongkan jika tidak ingin mengganti file.</div>
            @break

        @default {{-- short_text and any unrecognized type --}}
            <input type="text" name="{{ $fieldKey }}" value="{{ $current }}" class="form-control {{ $isError ? 'is-invalid' : '' }}">

    @endswitch

    @error($fieldKey)
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
