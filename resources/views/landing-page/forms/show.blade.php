@extends('landing-page.template.body')

@section('styles')
@include('landing-page.forms.components._form-styles')
@endsection

@section('content')
@php
    $formStartTs = time();

    // Extract header_image field (always top banner, not part of sections)
    $headerImageField = null;
    $contentFields    = [];
    foreach ($fields as $field) {
        if ($field->fieldType === 'header_image') {
            $headerImageField = $field;
        } else {
            $contentFields[] = $field;
        }
    }

    // Group remaining fields into sections separated by section_break fields.
    // Also build a map: section_break formFieldID → section index (for routing).
    $sections            = [];
    $sectionBreakToIndex = []; // formFieldID => secIndex
    $currentSec = [
        'title'       => $form->title,
        'description' => $form->description ?? '',
        'fields'      => [],
    ];
    foreach ($contentFields as $field) {
        if ($field->fieldType === 'section_break') {
            $newSecIdx                             = count($sections) + 1;
            $sectionBreakToIndex[$field->formFieldID] = $newSecIdx;
            $sections[] = $currentSec;
            $currentSec = [
                'title'       => $field->label,
                'description' => $field->helpText ?? '',
                'fields'      => [],
            ];
        } else {
            $currentSec['fields'][] = $field;
        }
    }
    $sections[] = $currentSec;
    $isMultiStep   = count($sections) > 1;
    $totalSections = count($sections);
    $jsSectionNames = [];
    foreach ($sections as $i => $s) {
        $jsSectionNames[] = $i === 0 ? '' : ($s['title'] ?? '');
    }
@endphp

<div class="gf-page">
    <div class="gf-wrap">

        {{-- ── Header Banner Image (pinned to very top when present) ── --}}
        @if($headerImageField && $headerImageField->helpText)
        <div class="gf-header-banner-wrap">
            <img src="{{ $headerImageField->helpText }}" alt="Form Header" class="gf-header-banner">
        </div>
        @endif

        {{-- ── Header Card (always visible) ────────────────────────── --}}
        <div class="gf-header-card">
            {{-- Section chip (multi-step only, sits inside card at top) --}}
            @if($isMultiStep)
            <div class="gf-section-chip" id="gfSectionIndicator">
                <span id="gfSectionIndicatorText">Bagian 1 dari {{ $totalSections }}</span>
            </div>
            @endif
            <h1 class="gf-form-title">{{ $form->title }}</h1>
            @if($form->description)
            <p class="gf-form-desc">{{ $form->description }}</p>
            @endif
            @if($isMultiStep)
            <div class="gf-progress-track gf-progress-track--hdr">
                <div class="gf-progress-bar" id="gfProgressBar" style="width: {{ round(100 / $totalSections) }}%"></div>
            </div>
            <div class="gf-progress-dots" style="margin-top:8px;">
                @for($d = 0; $d < $totalSections; $d++)
                <span class="gf-dot {{ $d === 0 ? 'active' : '' }}" data-dot="{{ $d }}"></span>
                @endfor
            </div>
            @endif
        </div>

        {{-- ── Form ─────────────────────────────────────────────────── --}}
        <form action="{{ route('forms.submit', $form->slug) }}" method="POST"
              enctype="multipart/form-data" id="publicFormSubmit" novalidate>
            @csrf

            {{-- Anti-spam honeypot (hidden, never filled by humans) --}}
            <div style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;"
                 aria-hidden="true" tabindex="-1">
                <input type="text" name="_hp_website" tabindex="-1" autocomplete="off" value="">
            </div>
            <input type="hidden" name="_form_ts" value="{{ $formStartTs }}">

            @if($isMultiStep)
                {{-- ── Multi-step sections ──────────────────────────── --}}
                @foreach($sections as $secIndex => $section)
                <div class="gf-form-section {{ $secIndex === 0 ? 'active' : '' }}" data-section="{{ $secIndex }}">

                    {{-- Fields in this section --}}
                    @foreach($section['fields'] as $field)
                        @include('landing-page.forms.components._field-renderer', ['field' => $field, 'sectionBreakToIndex' => $sectionBreakToIndex])
                    @endforeach

                    {{-- Section navigation --}}
                    <div class="gf-section-nav">
                        @if($secIndex > 0)
                        <button type="button" class="gf-nav-btn gf-nav-prev" onclick="gfPrevSection()">
                            <i class="fas fa-arrow-left me-1"></i> Sebelumnya
                        </button>
                        @else
                        <span></span>
                        @endif

                        @if($secIndex < $totalSections - 1)
                        <button type="button" class="gf-nav-btn gf-nav-next" onclick="gfNextSection()">
                            Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                        @else
                        {{-- Last section: show submit button here --}}
                        <button type="submit" class="gf-submit-btn" id="gfSubmitBtn">
                            <i class="fas fa-paper-plane me-1"></i>
                            <span>Kirimkan Formulir</span>
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach

            @else
                {{-- ── Single-page form (no section_break) ─────────── --}}
                @foreach($contentFields as $field)
                    @include('landing-page.forms.components._field-renderer', ['field' => $field, 'sectionBreakToIndex' => $sectionBreakToIndex])
                @endforeach

                {{-- ── Submit area ──────────────────────────────────── --}}
                <div class="gf-submit-area">
                    <button type="submit" class="gf-submit-btn" id="gfSubmitBtn">
                        <i class="fas fa-paper-plane"></i>
                        <span>Kirimkan Formulir</span>
                    </button>
                    <p class="gf-privacy-note">
                        <i class="fas fa-lock me-1"></i>
                        Data Anda aman dan terlindungi.
                    </p>
                </div>
            @endif

            @if($isMultiStep)
            <p class="gf-privacy-note gf-privacy-note--multistep">
                <i class="fas fa-lock me-1"></i>
                Data Anda aman dan terlindungi.
            </p>
            @endif

        </form>

        {{-- ── Meta footer ──────────────────────────────────────────── --}}
        <div class="gf-meta-footer">
            @if($form->endDate)
            <span><i class="fas fa-calendar-times me-1"></i>Ditutup: {{ $form->endDate->locale('id')->translatedFormat('d F Y, H:i') }} WIB</span>
            @endif
            @if($form->maxSubmission)
            <span class="ms-2"><i class="fas fa-users me-1"></i>Sisa kuota: {{ max(0, $form->maxSubmission - $form->totalSubmission) }} responden</span>
            @endif
        </div>

    </div>
</div>

@endsection

@section('scripts')
@include('landing-page.forms.components._form-scripts', ['isMultiStep' => $isMultiStep, 'totalSections' => $totalSections, 'jsSectionNames' => $jsSectionNames ?? []])
@endsection
