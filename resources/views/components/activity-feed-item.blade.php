@props(['icon' => '', 'description' => '', 'author' => '', 'timestamp' => '', 'type' => 'default', 'dateLabel' => ''])

@if($dateLabel)
    <div class="px-0 pt-2 pb-1">
        <span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant px-2 py-1 bg-surface-container-low rounded inline-block">
            {{ $dateLabel }}
        </span>
    </div>
@endif

<div {{ $attributes->merge(['class' => 'relative flex items-start gap-4 py-3']) }}>
    {{-- Linha vertical conectora --}}
    <div class="absolute left-4 top-10 bottom-0 w-[2px] bg-outline-variant -z-0"></div>

    {{-- Ícone circular --}}
    <div class="w-8 h-8 rounded-full {{ $iconBgClass() }} flex items-center justify-center flex-shrink-0 z-10">
        <span class="material-symbols-outlined text-sm {{ $iconTextClass() }}" style="font-variation-settings: 'FILL' 1;">
            {{ $resolvedIcon() }}
        </span>
    </div>

    {{-- Conteúdo --}}
    <div class="flex-1 min-w-0">
        @if($description)
            <p class="text-[13px] text-on-surface">{{ $description }}</p>
        @endif

        @if($slot->isNotEmpty())
            <div class="mt-1">{{ $slot }}</div>
        @endif

        <div class="flex items-center gap-2 mt-1">
            @if($author)
                <span class="text-[11px] font-semibold text-slate-600">{{ $author }}</span>
            @endif

            @if($author && $timestamp)
                <span class="text-[11px] text-slate-300">•</span>
            @endif

            @if($timestamp)
                <span class="text-[11px] text-slate-400">{{ $timestamp }}</span>
            @endif
        </div>
    </div>
</div>
