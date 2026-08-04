@props(['name'])
@php
    $n = \Illuminate\Support\Str::lower($name);
    $path = match (true) {
        str_contains($n, 'ar condicionado') => 'M12 3v18M3 12h18M6.5 6.5l11 11M17.5 6.5l-11 11',
        str_contains($n, 'wi-fi') || str_contains($n, 'wifi') => 'M5 12.5a10 10 0 0 1 14 0M8 15.5a6 6 0 0 1 8 0M12 18.5h.01',
        str_contains($n, 'tv') => 'M4 5h16v11H4zM9 20h6M8 16v4M16 16v4',
        str_contains($n, 'minibar') || str_contains($n, 'bar') => 'M5 4h14l-7 8zM12 12v6M8 20h8',
        str_contains($n, 'cofre') => 'M4 5h16v14H4zM15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0M12 12h.01',
        str_contains($n, 'trabalho') || str_contains($n, 'secretária') => 'M4 7h16M6 7v10M18 7v10M4 13h16M9 17v2M15 17v2',
        str_contains($n, 'kitchenette') || str_contains($n, 'cozinha') => 'M6 3v7a2 2 0 0 0 2 2h0V3M8 3v18M16 3c-1.5 0-2.5 2-2.5 4.5S14.5 12 16 12v9',
        str_contains($n, 'piscina') => 'M4 15c2 1.5 4 1.5 6 0s4-1.5 6 0 4 1.5 4 0M4 19c2 1.5 4 1.5 6 0s4-1.5 6 0 4 1.5 4 0M8 12V5a2 2 0 0 1 4 0',
        str_contains($n, 'estar') || str_contains($n, 'sala') || str_contains($n, 'sofá') => 'M4 11V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3M3 11a2 2 0 0 1 4 0v4h10v-4a2 2 0 0 1 4 0v6H3zM6 17v2M18 17v2',
        str_contains($n, 'ginás') || str_contains($n, 'fitness') => 'M4 9v6M20 9v6M6.5 7v10M17.5 7v10M6.5 12h11',
        str_contains($n, 'serviço de quarto') || str_contains($n, 'room service') => 'M4 18h16M6 18v-2a6 6 0 0 1 12 0v2M12 8V6',
        str_contains($n, 'seguran') => 'M12 3l7 3v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z',
        str_contains($n, 'rece') => 'M4 20v-1a8 8 0 0 1 16 0v1M12 12a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z',
        str_contains($n, 'lavandaria') || str_contains($n, 'lavandar') => 'M5 4h14v16H5zM12 17a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 7h.01M11 7h.01',
        default => 'M5 13l4 4L19 7',
    };
@endphp
<svg {{ $attributes->merge(['class' => 'h-5 w-5 text-copper-500']) }} fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
</svg>
