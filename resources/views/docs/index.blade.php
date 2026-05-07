<x-jetax-docs-layout title="Jetax — Visão Geral dos Componentes">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-[#e2e8f0] mb-2">Jetax Design System</h1>
        <p class="text-lg text-gray-600 dark:text-white/60">
            Biblioteca de componentes TALL Stack para Laravel — construída com Livewire, Alpine.js e Tailwind CSS.
        </p>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-10">
        <div class="bg-white dark:bg-[rgb(22,27,42)] rounded-xl border border-gray-200 dark:border-white/5 p-5">
            <div class="text-2xl font-bold text-blue-600 dark:text-[#60b4ff] mb-1">
                {{ collect($groups)->flatten(1)->count() }}
            </div>
            <div class="text-sm text-gray-600 dark:text-white/60">Componentes</div>
        </div>
        <div class="bg-white dark:bg-[rgb(22,27,42)] rounded-xl border border-gray-200 dark:border-white/5 p-5">
            <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-1">
                {{ count($groups) }}
            </div>
            <div class="text-sm text-gray-600 dark:text-white/60">Categorias</div>
        </div>
        <div class="bg-white dark:bg-[rgb(22,27,42)] rounded-xl border border-gray-200 dark:border-white/5 p-5">
            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-1">PHP 8.4+</div>
            <div class="text-sm text-gray-600 dark:text-white/60">Laravel 12+ / Livewire 4+</div>
        </div>
    </div>

    @foreach($groups as $category => $components)
        <section class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 dark:bg-[#60b4ff] rounded-full inline-block"></span>
                {{ $category }}
                <span class="text-sm font-normal text-gray-400 dark:text-white/45">({{ count($components) }})</span>
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($components as $component)
                    <a
                        href="/docs/components/{{ $component['slug'] }}"
                        class="bg-white dark:bg-[rgb(22,27,42)] rounded-lg border border-gray-200 dark:border-white/5 p-4 hover:border-blue-300 dark:hover:border-[#60b4ff]/30 hover:shadow-sm transition-all group"
                    >
                        <div class="font-medium text-gray-900 dark:text-[#e2e8f0] group-hover:text-blue-600 dark:group-hover:text-[#60b4ff] mb-1">
                            {{ $component['name'] }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-white/45 font-mono truncate">
                            {{ $component['tag'] }}
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endforeach

    <div class="mt-10 p-6 bg-blue-50 dark:bg-[#60b4ff]/10 rounded-xl border border-blue-200 dark:border-[#60b4ff]/20">
        <h3 class="font-semibold text-blue-900 dark:text-[#60b4ff] mb-2">Novo no Jetax?</h3>
        <p class="text-blue-700 dark:text-blue-300 text-sm mb-4">
            Comece pela página de instalação para configurar o Jetax no seu projeto Laravel.
        </p>
        <div class="flex gap-3">
            <a href="/docs/getting-started"
               class="inline-flex items-center gap-1 bg-blue-600 dark:bg-[#60b4ff] text-white dark:text-[#0f121b] text-sm px-4 py-2 rounded-lg hover:bg-blue-700 dark:hover:bg-[#60b4ff]/90">
                Primeiros Passos →
            </a>
            <a href="/docs/customization"
               class="inline-flex items-center gap-1 bg-white dark:bg-white/5 text-blue-600 dark:text-[#60b4ff] text-sm px-4 py-2 rounded-lg border border-blue-200 dark:border-[#60b4ff]/20 hover:bg-blue-50 dark:hover:bg-white/10">
                Customização
            </a>
        </div>
    </div>
</x-jetax-docs-layout>
