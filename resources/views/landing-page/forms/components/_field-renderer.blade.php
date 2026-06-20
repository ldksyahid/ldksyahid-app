{{--
    Renders a single form field for the public form.
    Variable: $field (MsFormField instance)
    Each field type renders its own .gf-card (Google Form style).
--}}
@php
    $fieldName = 'field_' . $field->formFieldID;
    $fieldID   = 'f_' . $field->formFieldID;
    $oldValue  = old($fieldName);
    $isError   = $errors->has($fieldName);
@endphp

@switch($field->fieldType)

{{-- ===== HEADER IMAGE (rendered as top banner in show.blade.php — nothing inline) ===== --}}
@case('header_image')
    @break

{{-- ===== SECTION BREAK ===== --}}
@case('section_break')
    <div class="gf-section-card">
        @if($field->label)
        <div class="gf-section-title">{{ $field->label }}</div>
        @endif
        @if($field->helpText)
        <p class="gf-section-desc">{{ $field->helpText }}</p>
        @endif
    </div>
    @break

{{-- ===== PARAGRAPH (display only) ===== --}}
@case('paragraph')
    <div class="gf-para-card">
        <p class="gf-para-text">{{ $field->label }}</p>
        @if($field->helpText)
        <p class="gf-para-text" style="margin-top:.5rem;font-size:.875rem;opacity:.75;">{{ $field->helpText }}</p>
        @endif
    </div>
    @break

{{-- ===== SHORT TEXT ===== --}}
@case('short_text')
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label" for="{{ $fieldID }}">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <input
            type="text"
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="gf-input {{ $isError ? 'is-invalid' : '' }}"
            placeholder="{{ $field->placeholder ?? 'Jawaban Anda' }}"
            value="{{ $oldValue ?? $field->defaultValue ?? '' }}"
            {{ $field->isRequired ? 'required' : '' }}
            maxlength="500"
        >
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== PHONE ===== --}}
@case('phone')
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label" for="{{ $fieldID }}">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <input
            type="tel"
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="gf-input {{ $isError ? 'is-invalid' : '' }}"
            placeholder="{{ $field->placeholder ?? 'Nomor telepon Anda' }}"
            value="{{ $oldValue ?? $field->defaultValue ?? '' }}"
            {{ $field->isRequired ? 'required' : '' }}
            maxlength="30"
            inputmode="tel"
            data-gf-tel="1"
        >
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== URL ===== --}}
@case('url')
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label" for="{{ $fieldID }}">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <input
            type="url"
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="gf-input {{ $isError ? 'is-invalid' : '' }}"
            placeholder="{{ $field->placeholder ?? 'https://' }}"
            value="{{ $oldValue ?? $field->defaultValue ?? '' }}"
            {{ $field->isRequired ? 'required' : '' }}
            maxlength="500"
        >
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== EMAIL ===== --}}
@case('email')
    @php
        $authEmail   = ($field->isSystemField && auth()->check()) ? auth()->user()->email : null;
        $emailValue  = $oldValue ?? $authEmail ?? '';
        $isReadonly  = $field->isSystemField && auth()->check();
    @endphp
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label" for="{{ $fieldID }}">
            {{ $field->label }}
            @if($field->isRequired || $field->isSystemField)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @elseif($field->isSystemField)
        <p class="gf-help">Email konfirmasi akan dikirimkan ke alamat ini.</p>
        @endif
        <input
            type="email"
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="gf-input {{ $isError ? 'is-invalid' : '' }} {{ $isReadonly ? 'gf-input-readonly' : '' }}"
            placeholder="{{ $field->placeholder ?? 'contoh@email.com' }}"
            value="{{ $emailValue }}"
            {{ ($field->isRequired || $field->isSystemField) ? 'required' : '' }}
            {{ $isReadonly ? 'readonly' : '' }}
            autocomplete="email"
            maxlength="255"
        >
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== NUMBER ===== --}}
@case('number')
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label" for="{{ $fieldID }}">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <input
            type="number"
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="gf-input {{ $isError ? 'is-invalid' : '' }}"
            placeholder="{{ $field->placeholder ?? '0' }}"
            value="{{ $oldValue ?? $field->defaultValue ?? '' }}"
            {{ $field->isRequired ? 'required' : '' }}
            @if(!empty($field->validation['min'])) min="{{ $field->validation['min'] }}" @endif
            @if(!empty($field->validation['max'])) max="{{ $field->validation['max'] }}" @endif
        >
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== LONG TEXT ===== --}}
@case('long_text')
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label" for="{{ $fieldID }}">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <textarea
            id="{{ $fieldID }}"
            name="{{ $fieldName }}"
            class="gf-textarea {{ $isError ? 'is-invalid' : '' }}"
            rows="4"
            placeholder="{{ $field->placeholder ?? 'Jawaban Anda' }}"
            {{ $field->isRequired ? 'required' : '' }}
        >{{ $oldValue ?? $field->defaultValue ?? '' }}</textarea>
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== DATE ===== --}}
@case('date')
    @php
        $dpRaw = $oldValue ?? ($field->defaultValue ?? '');
        $dpDisplay = '';
        if ($dpRaw) {
            $p = explode('-', $dpRaw);
            if (count($p) === 3) $dpDisplay = $p[2] . '/' . $p[1] . '/' . $p[0];
        }
    @endphp
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <div class="gf-dp-wrap{{ $isError ? ' is-invalid' : '' }}">
            <input type="date" id="{{ $fieldID }}" name="{{ $fieldName }}"
                   class="gf-dp-native" value="{{ $dpRaw }}"
                   {{ $field->isRequired ? 'required' : '' }}
                   aria-hidden="true" tabindex="-1">
            <div class="gf-dp-trigger" tabindex="0" role="button"
                 aria-haspopup="dialog" aria-expanded="false" aria-label="{{ $field->label }}">
                <span class="gf-dp-text{{ !$dpDisplay ? ' placeholder' : '' }}">
                    {{ $dpDisplay ?: 'Pilih tanggal' }}
                </span>
                <span class="gf-dp-icon"><i class="fas fa-calendar-alt"></i></span>
            </div>
            <div class="gf-dp-panel" role="dialog" aria-modal="true">
                <div class="gf-dp-header">
                    <button type="button" class="gf-dp-nav" data-dp="prev"><i class="fas fa-chevron-left"></i></button>
                    <button type="button" class="gf-dp-caption-btn">
                        <span class="gf-dp-caption"></span>
                        <i class="fas fa-chevron-down gf-dp-caption-arrow"></i>
                    </button>
                    <button type="button" class="gf-dp-nav" data-dp="next"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="gf-dp-weekdays">
                    <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span>
                    <span>Kam</span><span>Jum</span><span>Sab</span>
                </div>
                <div class="gf-dp-grid"></div>
                <div class="gf-dp-month-grid"></div>
                <div class="gf-dp-year-grid"></div>
                <div class="gf-dp-footer">
                    <button type="button" class="gf-dp-btn gf-dp-btn-clear">Hapus</button>
                    <button type="button" class="gf-dp-btn gf-dp-btn-today">Hari ini</button>
                </div>
            </div>
        </div>
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== TIME ===== --}}
@case('time')
    @php
        $tpRaw = $oldValue ?? ($field->defaultValue ?? '');
    @endphp
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <div class="gf-tp-wrap{{ $isError ? ' is-invalid' : '' }}">
            <input type="time" id="{{ $fieldID }}" name="{{ $fieldName }}"
                   class="gf-tp-native" value="{{ $tpRaw }}"
                   {{ $field->isRequired ? 'required' : '' }}
                   aria-hidden="true" tabindex="-1">
            <div class="gf-tp-trigger" tabindex="0" role="button"
                 aria-haspopup="dialog" aria-expanded="false" aria-label="{{ $field->label }}">
                <span class="gf-tp-text{{ !$tpRaw ? ' placeholder' : '' }}">
                    {{ $tpRaw ?: '--:--' }}
                </span>
                <span class="gf-tp-icon"><i class="fas fa-clock"></i></span>
            </div>
            <div class="gf-tp-panel" role="dialog" aria-modal="true">
                <div class="gf-tp-cols">
                    <div class="gf-tp-col-wrap">
                        <div class="gf-tp-col-label">Jam</div>
                        <div class="gf-tp-col" data-tp="hour"></div>
                    </div>
                    <div class="gf-tp-sep">:</div>
                    <div class="gf-tp-col-wrap">
                        <div class="gf-tp-col-label">Menit</div>
                        <div class="gf-tp-col" data-tp="minute"></div>
                    </div>
                </div>
                <div class="gf-tp-footer">
                    <button type="button" class="gf-tp-btn gf-tp-clear">Hapus</button>
                    <button type="button" class="gf-tp-btn gf-tp-now">Sekarang</button>
                </div>
            </div>
        </div>
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== DATETIME ===== --}}
@case('datetime')
    @php
        $dtpRaw = $oldValue ?? ($field->defaultValue ?? '');
        $dtpFull = '';
        if ($dtpRaw) {
            $dtpParts = explode('T', $dtpRaw);
            if (count($dtpParts) === 2) {
                $dd = explode('-', $dtpParts[0]);
                if (count($dd) === 3)
                    $dtpFull = $dd[2] . '/' . $dd[1] . '/' . $dd[0] . ' ' . $dtpParts[1];
            }
        }
    @endphp
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <div class="gf-dtp-wrap{{ $isError ? ' is-invalid' : '' }}">
            <input type="datetime-local" id="{{ $fieldID }}" name="{{ $fieldName }}"
                   class="gf-dtp-native" value="{{ $dtpRaw }}"
                   {{ $field->isRequired ? 'required' : '' }}
                   aria-hidden="true" tabindex="-1">
            <div class="gf-dtp-trigger" tabindex="0" role="button"
                 aria-haspopup="dialog" aria-expanded="false" aria-label="{{ $field->label }}">
                <span class="gf-dtp-text{{ !$dtpFull ? ' placeholder' : '' }}">
                    {{ $dtpFull ?: 'dd/mm/yyyy --:--' }}
                </span>
                <span class="gf-dtp-icon"><i class="fas fa-calendar-alt"></i></span>
            </div>
            <div class="gf-dtp-panel" role="dialog" aria-modal="true">
                <div class="gf-dtp-cal-header">
                    <button type="button" class="gf-dtp-nav" data-dtp="prev"><i class="fas fa-chevron-left"></i></button>
                    <button type="button" class="gf-dtp-caption-btn">
                        <span class="gf-dtp-caption"></span>
                        <i class="fas fa-chevron-down gf-dtp-caption-arrow"></i>
                    </button>
                    <button type="button" class="gf-dtp-nav" data-dtp="next"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="gf-dtp-weekdays">
                    <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span>
                    <span>Kam</span><span>Jum</span><span>Sab</span>
                </div>
                <div class="gf-dtp-grid"></div>
                <div class="gf-dtp-month-grid"></div>
                <div class="gf-dtp-year-grid"></div>
                <div class="gf-dtp-time-section">
                    <div class="gf-dtp-time-label">Waktu</div>
                    <div class="gf-dtp-time-cols">
                        <div class="gf-dtp-col-wrap">
                            <div class="gf-dtp-col-label">Jam</div>
                            <div class="gf-dtp-col" data-dtp="hour"></div>
                        </div>
                        <div class="gf-dtp-time-sep">:</div>
                        <div class="gf-dtp-col-wrap">
                            <div class="gf-dtp-col-label">Menit</div>
                            <div class="gf-dtp-col" data-dtp="minute"></div>
                        </div>
                    </div>
                </div>
                <div class="gf-dtp-footer">
                    <button type="button" class="gf-dtp-btn gf-dtp-btn-clear">Hapus</button>
                    <button type="button" class="gf-dtp-btn gf-dtp-btn-now">Sekarang</button>
                </div>
            </div>
        </div>
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== DROPDOWN ===== --}}
@case('dropdown')
    @php
        $selectedLabel  = '';
        if ($oldValue) {
            foreach ($field->options ?? [] as $_opt) {
                if ($_opt['value'] == $oldValue) { $selectedLabel = $_opt['label']; break; }
            }
        }
        $ddRoutingCfg = $field->fieldConfig['sectionRouting'] ?? null;
        $ddRouteMap   = []; // optionValue => secIndex
        if ($ddRoutingCfg && ($ddRoutingCfg['enabled'] ?? false)) {
            $sbMap = $sectionBreakToIndex ?? [];
            foreach ($ddRoutingCfg['routes'] ?? [] as $r) {
                $tid = $r['targetSectionFieldID'] ?? null;
                if ($tid && isset($sbMap[$tid])) {
                    $ddRouteMap[$r['optionValue']] = $sbMap[$tid];
                }
            }
        }
    @endphp
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label" for="{{ $fieldID }}">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <div class="gf-csel-wrap{{ $isError ? ' is-invalid' : '' }}">
            {{-- Hidden native select (form submission only) --}}
            <select id="{{ $fieldID }}" name="{{ $fieldName }}"
                    class="gf-csel-native"
                    {{ $field->isRequired ? 'required' : '' }}
                    @if(!empty($ddRouteMap)) data-section-routing="{{ json_encode($ddRouteMap) }}" @endif
                    aria-hidden="true" tabindex="-1">
                <option value="">-- Pilih salah satu --</option>
                @foreach($field->options ?? [] as $option)
                <option value="{{ $option['value'] }}" {{ $oldValue == $option['value'] ? 'selected' : '' }}>
                    {{ $option['label'] }}
                </option>
                @endforeach
            </select>
            {{-- Custom visual trigger --}}
            <div class="gf-csel-trigger" tabindex="0" role="combobox"
                 aria-expanded="false" aria-haspopup="listbox">
                <span class="gf-csel-current{{ !$selectedLabel ? ' placeholder' : '' }}">
                    {{ $selectedLabel ?: '-- Pilih salah satu --' }}
                </span>
                <span class="gf-csel-arrow"><i class="fas fa-chevron-down"></i></span>
            </div>
            {{-- Options panel --}}
            <div class="gf-csel-panel" role="listbox">
                <div class="gf-csel-option gf-csel-opt-placeholder" data-value="" role="option">
                    -- Pilih salah satu --
                </div>
                @foreach($field->options ?? [] as $option)
                <div class="gf-csel-option{{ $oldValue == $option['value'] ? ' selected' : '' }}"
                     data-value="{{ $option['value'] }}" role="option">
                    {{ $option['label'] }}
                </div>
                @endforeach
            </div>
        </div>
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== RADIO ===== --}}
@case('radio')
    @php
        $routingCfg  = $field->fieldConfig['sectionRouting'] ?? null;
        $routeMap    = []; // optionValue => secIndex (only for explicitly routed options)
        if ($routingCfg && ($routingCfg['enabled'] ?? false)) {
            $sbMap = $sectionBreakToIndex ?? [];
            foreach ($routingCfg['routes'] ?? [] as $r) {
                $tid = $r['targetSectionFieldID'] ?? null;
                if ($tid && isset($sbMap[$tid])) {
                    $routeMap[$r['optionValue']] = $sbMap[$tid];
                }
            }
        }
    @endphp
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <fieldset style="border:none;padding:0;margin:0;">
            <legend class="gf-label">
                {{ $field->label }}
                @if($field->isRequired)<span class="gf-required">*</span>@endif
            </legend>
            @if($field->helpText)
            <p class="gf-help">{{ $field->helpText }}</p>
            @endif
            <div class="gf-options">
                @foreach($field->options ?? [] as $i => $option)
                <label class="gf-option">
                    <input
                        class="gf-option-input"
                        type="radio"
                        name="{{ $fieldName }}"
                        id="{{ $fieldID }}_{{ $i }}"
                        value="{{ $option['value'] }}"
                        {{ $oldValue == $option['value'] ? 'checked' : '' }}
                        {{ $field->isRequired ? 'required' : '' }}
                        @if(isset($routeMap[$option['value']])) data-go-to-section="{{ $routeMap[$option['value']] }}" @endif
                    >
                    <span class="gf-option-label">{{ $option['label'] }}</span>
                </label>
                @endforeach
            </div>
            <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
        </fieldset>
    </div>
    @break

{{-- ===== CHECKBOX ===== --}}
@case('checkbox')
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <fieldset style="border:none;padding:0;margin:0;">
            <legend class="gf-label">
                {{ $field->label }}
                @if($field->isRequired)<span class="gf-required">*</span>@endif
            </legend>
            @if($field->helpText)
            <p class="gf-help">{{ $field->helpText }}</p>
            @endif
            <div class="gf-options">
                @foreach($field->options ?? [] as $i => $option)
                <label class="gf-option">
                    <input
                        class="gf-option-input"
                        type="checkbox"
                        name="{{ $fieldName }}[]"
                        id="{{ $fieldID }}_{{ $i }}"
                        value="{{ $option['value'] }}"
                        {{ is_array($oldValue) && in_array($option['value'], $oldValue) ? 'checked' : '' }}
                    >
                    <span class="gf-option-label">{{ $option['label'] }}</span>
                </label>
                @endforeach
            </div>
            <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
        </fieldset>
    </div>
    @break

{{-- ===== LINEAR SCALE ===== --}}
@case('linear_scale')
    @php
        $lsConfig   = $field->fieldConfig ?? [];
        $lsMin      = (int) ($lsConfig['minValue'] ?? 1);
        $lsMax      = (int) ($lsConfig['maxValue'] ?? 5);
        $lsMinLabel = $lsConfig['minLabel'] ?? '';
        $lsMaxLabel = $lsConfig['maxLabel'] ?? '';
    @endphp
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <div class="gf-linear-scale">
            <div class="gf-scale-row">
                @if($lsMinLabel)
                <span class="gf-scale-edge-label gf-scale-min-label">{{ $lsMinLabel }}</span>
                @endif
                <div class="gf-scale-options">
                    @for($n = $lsMin; $n <= $lsMax; $n++)
                    <label class="gf-scale-option">
                        <span class="gf-scale-number">{{ $n }}</span>
                        <input
                            class="gf-option-input gf-scale-radio"
                            type="radio"
                            name="{{ $fieldName }}"
                            id="{{ $fieldID }}_{{ $n }}"
                            value="{{ $n }}"
                            {{ (string)$oldValue === (string)$n ? 'checked' : '' }}
                            {{ $field->isRequired ? 'required' : '' }}
                        >
                    </label>
                    @endfor
                </div>
                @if($lsMaxLabel)
                <span class="gf-scale-edge-label gf-scale-max-label">{{ $lsMaxLabel }}</span>
                @endif
            </div>
        </div>
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== RATING ===== --}}
@case('rating')
    @php
        $rtConfig = $field->fieldConfig ?? [];
        $rtMax    = (int) ($rtConfig['maxRating'] ?? 5);
    @endphp
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif
        <div class="gf-rating-wrap" data-field="{{ $fieldName }}">
            @for($n = 1; $n <= $rtMax; $n++)
            <label class="gf-rating-item">
                <input
                    type="radio"
                    class="gf-rating-input"
                    name="{{ $fieldName }}"
                    id="{{ $fieldID }}_{{ $n }}"
                    value="{{ $n }}"
                    {{ (string)$oldValue === (string)$n ? 'checked' : '' }}
                    {{ $field->isRequired ? 'required' : '' }}
                >
                <span class="gf-rating-num">{{ $n }}</span>
                <i class="gf-star far fa-star"></i>
            </label>
            @endfor
        </div>
        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== IMAGE (display only — embedded image in form) ===== --}}
@case('image')
    @if($field->helpText)
    <div class="gf-image-card">
        <img src="{{ $field->helpText }}" alt="{{ $field->label }}" class="gf-embedded-image">
        @if($field->label)
        <p class="gf-image-caption">{{ $field->label }}</p>
        @endif
    </div>
    @endif
    @break

{{-- ===== FILE ===== --}}
@case('file')
    <div class="gf-card {{ $isError ? 'has-error' : '' }}">
        <label class="gf-label">
            {{ $field->label }}
            @if($field->isRequired)<span class="gf-required">*</span>@endif
        </label>
        @if($field->helpText)
        <p class="gf-help">{{ $field->helpText }}</p>
        @endif

        <div class="gf-file-drop" id="drop_{{ $fieldID }}">
            <input
                type="file"
                id="{{ $fieldID }}"
                name="{{ $fieldName }}"
                {{ $field->isRequired ? 'required' : '' }}
                @if($field->fieldType === 'image') accept="image/*" @endif
                @if(!empty($field->validation['acceptedTypes']))
                    accept=".{{ implode(',.', (array) $field->validation['acceptedTypes']) }}"
                @endif
            >
            <span class="gf-file-upload-icon">
                <i class="fas fa-{{ $field->fieldType === 'image' ? 'image' : 'cloud-upload-alt' }}"></i>
            </span>
            <div class="gf-file-hint">Klik atau seret file ke sini</div>
            <div class="gf-file-meta">
                @if(!empty($field->validation['acceptedTypes']))
                Format: {{ implode(', ', (array) $field->validation['acceptedTypes']) }}<br>
                @endif
                @if(!empty($field->validation['maxSizeKB']))
                Maks: {{ number_format($field->validation['maxSizeKB'] / 1024, 1) }} MB
                @endif
            </div>
            <div class="gf-file-badge">
                <i class="fas fa-paperclip fa-xs"></i>
                <span>Belum ada file dipilih</span>
            </div>
        </div>

        <span class="gf-invalid">@error($fieldName){{ $message }}@enderror</span>
    </div>
    @break

{{-- ===== FALLBACK ===== --}}
@default
    <div class="gf-card">
        <label class="gf-label">{{ $field->label }}</label>
        <input type="text" name="{{ $fieldName }}" class="gf-input"
               placeholder="{{ $field->placeholder ?? '' }}">
    </div>

@endswitch
