@props(['horizontal' => false])

@if($horizontal)
    <div {{ $attributes->merge(['class' => 'flex flex-row items-start overflow-x-auto relative']) }}>
        {{-- Linha conectora horizontal no centro dos marcadores --}}
        <div class="absolute top-[11px] left-6 right-6 h-[2px] bg-slate-200 z-0"></div>
        {{ $slot }}
    </div>
@else
    <div {{ $attributes->merge(['class' => $containerClasses()]) }}>
        {{ $slot }}
    </div>
@endif
