@php
    $user = \App\Models\User::find($value)->first_name . ' ' . \App\Models\User::find($value)->last_name;
@endphp
<span>{{ $user }}</span>
