@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.setting.components._index-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">

            {{-- Page Title --}}
            <div class="text-center mb-3">
                <h1 class="page-title">
                    <i class="fas fa-cog me-2"></i>Application Settings
                </h1>
            </div>

            @if($grouped->isEmpty())
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 text-center text-muted">
                            <i class="fas fa-cog fa-3x mb-3 opacity-25 d-block"></i>
                            No settings found.
                        </div>
                    </div>
                </div>
            @else
                @foreach($grouped as $key1 => $rows)
                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">

                            {{-- Section header --}}
                            <h5 class="section-title mb-4">
                                <i class="fas fa-layer-group me-2"></i>{{ $key1 }}
                            </h5>

                            {{-- Setting rows --}}
                            @foreach($rows as $row)
                            <div class="setting-row" data-key1="{{ $row->key1 }}" data-key2="{{ $row->key2 }}">
                                <label class="form-label fw-semibold mb-0 setting-label">
                                    {{ $row->key2 }}
                                </label>
                                <input type="text"
                                       class="form-control form-control-sm inp-value1"
                                       value="{{ $row->value1 }}"
                                       placeholder="Value 1" />
                                <input type="text"
                                       class="form-control form-control-sm inp-value2"
                                       value="{{ $row->value2 }}"
                                       placeholder="Value 2 (optional)" />
                                <button type="button"
                                        class="btn btn-custom-primary btn-sm btn-save-row btn-save-setting">
                                    <i class="fas fa-save me-1"></i>Save
                                </button>
                                <span class="setting-saved-badge">
                                    <i class="fas fa-check-circle"></i> Saved
                                </span>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                @endforeach
            @endif

        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('admin-page.setting.components._index-scripts')
@endsection
