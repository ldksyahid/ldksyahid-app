@if (Auth::User() == !null)
    @if (Auth::User()->email_verified_at == null)
        @include('auth.verify')
    @else

    @endif
@else
    @yield('content')
@endif
