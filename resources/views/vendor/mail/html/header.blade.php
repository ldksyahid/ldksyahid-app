<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'ldksyahid-app')
<img src="{{ asset('Images/Logos/logoldksyahid.png') }}" class="logo" alt="UKM LDK Syahid">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
