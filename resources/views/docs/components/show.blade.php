<x-jetax-docs-layout :title="$componentData['name'] . ' — Jetax'">
    <x-jetax-page-header
        :title="$componentData['name']"
        :subtitle="$componentData['description']"
        :breadcrumbs="[
            ['label' => 'Docs', 'url' => '/docs'],
            ['label' => $componentData['category'], 'url' => '/docs'],
            ['label' => $componentData['name']],
        ]"
    >
        <x-slot:actions>
            <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded-full font-medium">
                {{ $componentData['category'] }}
            </span>
            <code class="text-xs bg-slate-100 dark:bg-white/10 px-2 py-0.5 rounded font-mono text-slate-600 dark:text-slate-300">
                {{ $componentData['tag'] }}
            </code>
        </x-slot:actions>
    </x-jetax-page-header>

    <div class="space-y-6" data-component-slug="{{ $componentData['slug'] }}">
        {{-- Preview por secoes (novo formato) --}}
        @if(!empty($componentData['preview_partial']))
            @include($componentData['preview_partial'])
        @endif

        {{-- Props --}}
        @if(!empty($componentData['props']))
            <x-jetax-card padding="0">
                <x-slot:header>Props</x-slot:header>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-white/[0.03]">
                            <tr>
                                <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest font-label">Nome</th>
                                <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest font-label">Tipo</th>
                                <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest font-label">Padrão</th>
                                <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest font-label">Descrição</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/50 dark:divide-white/[0.07]">
                            @foreach($componentData['props'] as $prop)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-4">
                                        <code class="text-sm font-mono text-[#0061a5] dark:text-[#60b4ff] bg-blue-50 dark:bg-blue-900/20 px-1.5 py-0.5 rounded">
                                            {{ $prop['name'] }}
                                        </code>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-mono text-purple-600 dark:text-purple-400">{{ $prop['type'] }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <code class="text-sm font-mono text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-white/10 px-1.5 py-0.5 rounded">
                                            {{ $prop['default'] }}
                                        </code>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                        {{ $prop['description'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-jetax-card>
        @endif

        {{-- Slots --}}
        @if(!empty($componentData['slots']))
            <x-jetax-card padding="0">
                <x-slot:header>Slots</x-slot:header>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-white/[0.03]">
                            <tr>
                                <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest font-label">Nome</th>
                                <th class="text-left px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest font-label">Descrição</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/50 dark:divide-white/[0.07]">
                            @foreach($componentData['slots'] as $slot)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-4">
                                        <code class="text-sm font-mono text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-1.5 py-0.5 rounded">
                                            {{ $slot['name'] }}
                                        </code>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                        {{ $slot['description'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-jetax-card>
        @endif

    </div>

    {{-- Navegação entre componentes --}}
    @php
        $allComponents = \Jetax\DesignSystem\Docs\ComponentRegistry::components();
        $currentIndex = collect($allComponents)->search(fn($c) => $c['slug'] === $componentData['slug']);
        $prevComponent = $currentIndex > 0 ? $allComponents[$currentIndex - 1] : null;
        $nextComponent = $currentIndex < count($allComponents) - 1 ? $allComponents[$currentIndex + 1] : null;
    @endphp

    <div class="mt-10 flex justify-between">
        @if($prevComponent)
            <a href="/docs/components/{{ $prevComponent['slug'] }}"
               class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 hover:text-[#0061a5] dark:hover:text-[#60b4ff] group transition-colors">
                <span class="material-symbols-outlined text-lg">chevron_left</span>
                <div>
                    <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest font-label">Anterior</div>
                    <div class="font-medium font-headline group-hover:text-[#0061a5] dark:group-hover:text-[#60b4ff]">{{ $prevComponent['name'] }}</div>
                </div>
            </a>
        @else
            <div></div>
        @endif

        @if($nextComponent)
            <a href="/docs/components/{{ $nextComponent['slug'] }}"
               class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 hover:text-[#0061a5] dark:hover:text-[#60b4ff] group text-right transition-colors">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest font-label">Próximo</div>
                    <div class="font-medium font-headline group-hover:text-[#0061a5] dark:group-hover:text-[#60b4ff]">{{ $nextComponent['name'] }}</div>
                </div>
                <span class="material-symbols-outlined text-lg">chevron_right</span>
            </a>
        @endif
    </div>
</x-jetax-docs-layout>

<script>
function copyCode(button) {
    const code = button.getAttribute('data-code');
    navigator.clipboard.writeText(code).then(() => {
        const original = button.innerHTML;
        button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Copiado!';
        button.classList.add('text-green-600');
        setTimeout(() => {
            button.innerHTML = original;
            button.classList.remove('text-green-600');
        }, 2000);
    });
}
</script>
