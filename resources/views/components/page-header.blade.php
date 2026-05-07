<div {{ $attributes->merge(['class' => 'pb-9']) }}>
    @if(!empty($breadcrumbs))
        <x-jetax-breadcrumbs :items="$breadcrumbs" class="mb-2" />
    @endif

    <div class="flex items-end justify-between">
        <div>
            <h2 class="text-[2.25rem] font-headline font-light text-on-surface dark:text-[#e2e8f0] tracking-tight">{{ $title }}</h2>

            @if($subtitle)
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>

        @if(isset($actions))
            <div class="flex items-center gap-3">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
