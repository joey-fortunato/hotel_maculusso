@php($locale = request()->segment(1) === 'en' ? 'en' : 'pt')
@php(app()->setLocale($locale))
<x-layouts.public title="Página não encontrada | Maculusso Hotel">
    <x-public.header :locale="$locale" />
    <main class="relative isolate flex min-h-[80vh] items-center overflow-hidden bg-espresso-900 px-6 text-center text-white">
        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=2200&q=80" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-25">
        <div class="absolute inset-0 -z-10 bg-espresso-900/70"></div>
        <div class="mx-auto max-w-2xl">
            <p class="eyebrow text-copper-400">Erro 404</p>
            <span class="rule-copper mx-auto mt-5"></span>
            <h1 class="mt-6 font-display text-5xl leading-tight sm:text-6xl">Esta página não faz parte da estadia.</h1>
            <p class="mt-5 text-lg leading-8 text-sand-200/80">O endereço pode ter mudado. Volte à página inicial e deixe-nos guiá-lo.</p>
            <a href="{{ lroute('home') }}" class="btn btn-gold mt-8">Voltar ao início</a>
        </div>
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
