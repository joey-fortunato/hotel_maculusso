<x-admin.layout title="Mensagem">
    <a href="{{ route('admin.messages.index') }}" class="link-arrow"><span aria-hidden="true">&larr;</span> Voltar às mensagens</a>

    <div class="mt-6 max-w-2xl border border-sand-200 bg-white p-8 shadow-sm">
        <div class="flex items-start justify-between gap-4 border-b border-sand-200 pb-5">
            <div>
                <p class="text-lg font-semibold">{{ $message->name }}</p>
                <a href="mailto:{{ $message->email }}" class="text-sm text-copper-600 hover:underline">{{ $message->email }}</a>
            </div>
            <p class="text-xs text-espresso-900/45">{{ $message->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <p class="mt-5 whitespace-pre-line leading-7 text-espresso-900/80">{{ $message->body }}</p>

        <div class="mt-8 flex gap-3">
            <a href="mailto:{{ $message->email }}" class="btn btn-gold">Responder por email</a>
            <form method="post" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Eliminar esta mensagem?')">
                @csrf @method('delete')
                <button class="btn btn-light">Eliminar</button>
            </form>
        </div>
    </div>
</x-admin.layout>
