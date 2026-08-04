<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar · Maculusso CMS</title>
    <link rel="icon" href="{{ asset('images/brand/maculusso-logo.png') }}" type="image/png">
    @vite(['resources/css/app.css'])
</head>
<body class="cms relative grid min-h-screen place-items-center overflow-hidden px-6 text-espresso-900">
    {{-- Background image + black overlay --}}
    <img src="{{ img_src(setting('hero_image')) }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover">
    <div class="absolute inset-0 -z-10 bg-black/70"></div>

    <div class="relative w-full max-w-sm border-t-2 border-copper-500 bg-sand-50 p-8 shadow-2xl sm:p-10">
        <img src="{{ asset('images/brand/maculusso-logo.png') }}" alt="Maculusso Hotel" class="mx-auto h-14 w-auto">
        <h1 class="mt-6 text-center font-display text-3xl leading-tight">Painel de gestão</h1>
        <p class="mt-2 text-center text-sm text-espresso-900/55">Entre com as suas credenciais.</p>

        @if($errors->any())
            <p class="mt-6 border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</p>
        @endif

        <form method="post" action="{{ route('admin.login.submit') }}" class="mt-6 grid gap-4">
            @csrf
            <div>
                <label class="mb-2 block font-caps text-[10px] font-semibold uppercase tracking-[.18em] text-copper-600">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-sand-300 bg-white px-4 py-3 text-sm focus:border-copper-500 focus:outline-none focus:ring-1 focus:ring-copper-400/40">
            </div>
            <div>
                <label class="mb-2 block font-caps text-[10px] font-semibold uppercase tracking-[.18em] text-copper-600">Palavra-passe</label>
                <input type="password" name="password" required
                       class="w-full border border-sand-300 bg-white px-4 py-3 text-sm focus:border-copper-500 focus:outline-none focus:ring-1 focus:ring-copper-400/40">
            </div>
            <label class="flex items-center gap-2 text-sm text-espresso-900/70">
                <input type="checkbox" name="remember" class="accent-copper-500"> Manter sessão iniciada
            </label>
            <button type="submit" class="btn btn-gold mt-2 w-full">Entrar</button>
        </form>
    </div>
</body>
</html>
