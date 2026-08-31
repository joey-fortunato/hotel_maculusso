<x-layouts.public :title="'Contactos | '.setting('name')">
    <x-public.header :locale="$locale" />
    <main>
        <x-public.page-hero
            :eyebrow="__('Contactos')"
            :title="setting('contact_hero_title')"
            :body="setting('contact_hero_body')"
            :image="img_src(setting('contact_hero_image'))" />

        <section class="mx-auto max-w-7xl px-6 py-24 lg:px-10 lg:py-32">
            <div class="grid gap-16 lg:grid-cols-2 lg:gap-24">
                {{-- Info --}}
                <div>
                    <p class="eyebrow text-copper-600">{{ __('Fale connosco') }}</p>
                    <span class="rule-copper mt-5"></span>
                    <h2 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ __('Como podemos ajudar?') }}</h2>

                    <div class="mt-10 grid gap-6 text-sm">
                        <div class="border-b border-sand-200 pb-6">
                            <p class="eyebrow text-espresso-900/40">{{ __('Reservas') }}</p>
                            <a href="tel:{{ setting('phone_link') }}" class="mt-2 block font-display text-2xl transition hover:text-copper-600">{{ setting('phone') }}</a>
                        </div>
                        <div class="border-b border-sand-200 pb-6">
                            <p class="eyebrow text-espresso-900/40">{{ __('Email') }}</p>
                            <a href="mailto:{{ setting('email') }}" class="mt-2 block font-display text-2xl transition hover:text-copper-600">{{ setting('email') }}</a>
                        </div>
                        <div class="border-b border-sand-200 pb-6">
                            <p class="eyebrow text-espresso-900/40">{{ __('Morada') }}</p>
                            <p class="mt-2 font-display text-2xl">{{ setting('address') }}</p>
                        </div>
                        <div>
                            <p class="eyebrow text-espresso-900/40">{{ __('Horário') }}</p>
                            <p class="mt-2 font-display text-2xl">{{ __('Receção disponível 24 horas') }}</p>
                        </div>
                    </div>

                    <a href="{{ setting('whatsapp') }}" class="btn btn-gold mt-10">{{ __('Falar por WhatsApp') }}</a>
                </div>

                {{-- Form (stored in the CMS) --}}
                <div class="bg-white p-8 shadow-sm lg:p-10">
                    @if(session('contact_sent'))
                        <div class="mb-5 border-l-2 border-copper-500 bg-sand-50 px-4 py-3 text-sm">{{ __('Mensagem enviada. A nossa equipa responderá em breve.') }}</div>
                    @endif
                    <form class="grid gap-5" action="{{ route('contact.store') }}" method="post">
                        @csrf
                        <x-public.form-guard />
                        <label class="text-xs font-semibold uppercase tracking-[.14em] text-espresso-900/60">{{ __('Nome') }}
                            <input class="mt-2 w-full border border-sand-200 bg-sand-50 px-4 py-3 text-base text-espresso-900 focus:border-copper-500 focus:outline-none @error('name') border-red-400 @enderror" type="text" name="name" value="{{ old('name') }}" required>
                            @error('name')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <label class="text-xs font-semibold uppercase tracking-[.14em] text-espresso-900/60">Email
                            <input class="mt-2 w-full border border-sand-200 bg-sand-50 px-4 py-3 text-base text-espresso-900 focus:border-copper-500 focus:outline-none @error('email') border-red-400 @enderror" type="email" name="email" value="{{ old('email') }}" required>
                            @error('email')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <label class="text-xs font-semibold uppercase tracking-[.14em] text-espresso-900/60">{{ __('Mensagem') }}
                            <textarea class="mt-2 min-h-36 w-full border border-sand-200 bg-sand-50 px-4 py-3 text-base text-espresso-900 focus:border-copper-500 focus:outline-none @error('body') border-red-400 @enderror" name="body" required>{{ old('body') }}</textarea>
                            @error('body')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <button class="btn btn-gold w-full" type="submit">{{ __('Enviar mensagem') }}</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
