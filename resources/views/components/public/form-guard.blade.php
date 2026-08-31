{{-- Anti-bot fields: honeypot + signed render timestamp. Pairs with the BotGuard middleware. --}}
@php $formTs = \Illuminate\Support\Facades\Crypt::encryptString((string) time()); @endphp
<div aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;" tabindex="-1">
    <label>Website (deixe em branco)
        <input type="text" name="website" value="" tabindex="-1" autocomplete="off">
    </label>
</div>
<input type="hidden" name="_ts" value="{{ $formTs }}">
