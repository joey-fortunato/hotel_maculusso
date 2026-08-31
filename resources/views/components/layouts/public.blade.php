@php
    $roomsJson = \App\Models\Room::published()->ordered()->get()->map(fn ($r) => [
        'slug' => $r->slug, 'name' => $r->tr('name'), 'price' => $r->price, 'price_double' => $r->price_double,
        'max_guests' => $r->max_guests, 'detail' => $r->detailLine(), 'description' => $r->tr('description'),
    ])->values();
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $description ?? 'Maculusso Hotel — um refúgio boutique no coração de Luanda. Quartos serenos, gastronomia de autor e uma equipa que cuida de cada detalhe.' }}">
    <title>{{ $title ?? setting('name') }}</title>
    <link rel="icon" href="{{ asset('images/brand/maculusso-logo.png') }}" type="image/png">
    <style>[x-cloak]{display:none!important}</style>
    <script>
        window.HOTEL_ROOMS = @json($roomsJson);
        window.APP_LOCALE = "{{ app()->getLocale() }}";
        window.RESERVATION_URL = "{{ route('reservation.store') }}";
        window.CSRF_TOKEN = document.querySelector('meta[name=csrf-token]').content;
        window.FORM_TS = "{{ \Illuminate\Support\Facades\Crypt::encryptString((string) time()) }}";
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data class="bg-sand-50 text-espresso-900 antialiased">
    @if(setting('maintenance_mode') === '1' && auth()->check() && auth()->user()->is_admin)
        <div class="fixed inset-x-0 bottom-0 z-[70] flex items-center justify-center gap-3 bg-amber-500 px-4 py-2.5 text-center text-xs font-semibold text-espresso-900 sm:text-sm">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/></svg>
            Modo de manutenção ativo — o site está oculto para os visitantes. Só você o vê.
            <a href="{{ route('admin.dashboard') }}" class="underline underline-offset-2 hover:no-underline">Gerir</a>
        </div>
    @endif
    {{ $slot }}
    <x-public.booking-modal />
</body>
</html>
