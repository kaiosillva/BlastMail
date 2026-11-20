@props([
    'post' => null,
    'put' => null,
    'flat' => false,
    'delete' => null,
    'patch' => null,
])

@php
    $method = ($post or $delete or $put or $patch) ? 'POST' : 'GET';
@endphp
<form {{ $attributes->class(['gap-4 flex flex-col' => !$flat]) }} method="{{ $method }}">
    @if ($method != 'GET')
        @csrf
    @endif
    @if ($put)
        @method('PUT')
    @endif
    @if ($delete)
        @method('DELETE')
    @endif
    @if ($patch)
        @method('PATCH')
    @endif
    {{ $slot }}
</form>
