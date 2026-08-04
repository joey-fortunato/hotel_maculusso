@props(['flag', 'name', 'type' => 'text', 'value' => null])
<div>
    <span class="mb-1 inline-block rounded-sm bg-espresso-900/5 px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-[.1em] {{ $flag === 'EN' ? 'text-copper-600' : 'text-espresso-900/45' }}">{{ $flag }}</span>
    @if($type === 'textarea')
        <textarea name="{{ $name }}" rows="4" class="cms-input" placeholder="{{ $flag === 'EN' ? 'English…' : '' }}">{{ $value }}</textarea>
    @else
        <input type="text" name="{{ $name }}" value="{{ $value }}" class="cms-input" placeholder="{{ $flag === 'EN' ? 'English…' : '' }}">
    @endif
</div>
