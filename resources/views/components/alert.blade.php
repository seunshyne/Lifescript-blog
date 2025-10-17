@props(['type' => 'info'])

@php
    $colors = [
        'success' => 'green',
        'error' => 'red',
        'warning' => 'orange',
        'info' => 'blue',
    ];
    $color = $colors[$type] ?? 'blue';

@endphp

<div style="padding: 10px; border: 1px solid {{ $color }}; background: {{ $color }}; margin-bottom: 10px;">
    <strong>{{ ucfirst($type)}}:</strong> {{ $slot }}
</div>
