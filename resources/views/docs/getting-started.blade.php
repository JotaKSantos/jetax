<x-jetax-docs-layout title="Primeiros Passos — Jetax">
    <div class="mb-8">
        <nav class="text-sm text-gray-500 dark:text-white/45 mb-4">
            <a href="/docs" class="hover:text-blue-600 dark:hover:text-[#60b4ff]">Docs</a>
            <span class="mx-2">›</span>
            <span class="text-gray-800 dark:text-[#e2e8f0]/80">Primeiros Passos</span>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-[#e2e8f0] mb-2">Primeiros Passos</h1>
        <p class="text-lg text-gray-600 dark:text-white/60">
            Instale e configure o Jetax no seu projeto Laravel em poucos minutos.
        </p>
    </div>

    {{-- Requisitos --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">Requisitos</h2>
        <div class="bg-white dark:bg-[rgb(22,27,42)] rounded-xl border border-gray-200 dark:border-white/5 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-[rgb(28,34,52)]">
                    <tr>
                        <th class="text-left px-4 py-3 text-sm font-medium text-gray-600 dark:text-white/45">Pacote</th>
                        <th class="text-left px-4 py-3 text-sm font-medium text-gray-600 dark:text-white/45">Versão mínima</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/[0.07]">
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-4 py-3 text-sm font-mono text-gray-800 dark:text-[#e2e8f0]">php</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-white/60">8.4+</td>
                    </tr>
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-4 py-3 text-sm font-mono text-gray-800 dark:text-[#e2e8f0]">laravel/framework</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-white/60">12.0+</td>
                    </tr>
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-4 py-3 text-sm font-mono text-gray-800 dark:text-[#e2e8f0]">livewire/livewire</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-white/60">4.0+</td>
                    </tr>
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-4 py-3 text-sm font-mono text-gray-800 dark:text-[#e2e8f0]">tailwindcss</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-white/60">4.0+</td>
                    </tr>
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-4 py-3 text-sm font-mono text-gray-800 dark:text-[#e2e8f0]">alpinejs</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-white/60">3.0+</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Instalação --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">1. Instalação via Composer</h2>
        <p class="text-gray-600 dark:text-white/60 mb-3">
            Execute o comando abaixo na raiz do seu projeto Laravel:
        </p>
        <pre class="bg-gray-900 text-green-400 rounded-xl p-4 text-sm"><code>composer require jksantos/jetax</code></pre>

        <div class="mt-4 p-4 bg-blue-50 dark:bg-[#60b4ff]/10 rounded-lg border border-blue-200 dark:border-[#60b4ff]/20">
            <p class="text-sm text-blue-800 dark:text-blue-300">
                <strong>Auto-discovery:</strong> O Laravel detectará automaticamente o
                <code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">JetaxServiceProvider</code>
                graças ao mecanismo de package auto-discovery. Nenhuma configuração adicional é necessária.
            </p>
        </div>
    </section>

    {{-- Configurar CSS --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">2. Configurar o CSS</h2>
        <p class="text-gray-600 dark:text-white/60 mb-3">
            Como o Tailwind CSS 4+ é um requisito, o Jetax é integrado via <code class="bg-gray-100 dark:bg-white/10 dark:text-slate-300 px-1 rounded">@import</code> no seu
            <code class="bg-gray-100 dark:bg-white/10 dark:text-slate-300 px-1 rounded">resources/css/app.css</code> — sem tags <code class="bg-gray-100 dark:bg-white/10 dark:text-slate-300 px-1 rounded">&lt;link&gt;</code> no layout.
        </p>

        <div class="mt-2 mb-4 p-4 bg-amber-50 dark:bg-amber-500/10 rounded-lg border border-amber-200 dark:border-amber-500/20">
            <p class="text-sm text-amber-800 dark:text-amber-300">
                <strong>Ordem importa:</strong> Os imports do Google Fonts devem ser os <strong>primeiros</strong> do arquivo.
                Quando colocados dentro de pacotes Tailwind, o Vite gera alertas de build ao processar URLs externas.
            </p>
        </div>

        <pre class="bg-gray-900 text-gray-100 rounded-xl p-4 text-sm"><code>/* resources/css/app.css */

/* 1. Google Fonts — SEMPRE antes de qualquer outro @import */
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300;600;700;800&family=Inter:wght@400;500;600&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap');

/* 2. Tailwind CSS */
@import "tailwindcss";

/* 3. Jetax Design System */
@import "../../vendor/jksantos/jetax/resources/css/jetax.css";
@source "../../vendor/jksantos/jetax/resources/views";</code></pre>
    </section>

    {{-- Layout principal --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">3. Layout principal</h2>
        <p class="text-gray-600 dark:text-white/60 mb-3">
            Se você usar o layout do Jetax (<code class="bg-gray-100 dark:bg-white/10 dark:text-slate-300 px-1 rounded">&lt;x-jetax-layout&gt;</code>),
            ele já inclui tudo automaticamente. Caso use seu próprio layout, inclua estas diretivas:
        </p>
        <pre class="bg-gray-900 text-gray-100 rounded-xl p-4 text-sm"><code>&lt;!DOCTYPE html&gt;
&lt;html lang="pt-BR"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &#64;livewireStyles
    &#64;vite(['resources/css/app.css', 'resources/js/app.js'])
&lt;/head&gt;
&lt;body&gt;
    &#123;&#123; $slot &#125;&#125;

    &#64;livewireScripts &#123;&#123;-- Carrega Alpine.js automaticamente --&#125;&#125;
&lt;/body&gt;
&lt;/html&gt;</code></pre>

        <div class="mt-4 p-4 bg-blue-50 dark:bg-[#60b4ff]/10 rounded-lg border border-blue-200 dark:border-[#60b4ff]/20">
            <p class="text-sm text-blue-800 dark:text-blue-300">
                <strong>Dica:</strong> O layout do Jetax (<code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">&lt;x-jetax-layout&gt;</code>)
                já inclui <code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">&#64;livewireStyles</code>,
                <code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">&#64;livewireScripts</code> e
                <code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">&#64;vite</code> — o exemplo acima só é necessário para layouts customizados.
                O Alpine.js é carregado automaticamente via <code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">&#64;livewireScripts</code>.
            </p>
        </div>
    </section>

    {{-- Uso básico --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">4. Use os componentes</h2>
        <p class="text-gray-600 dark:text-white/60 mb-3">
            Todos os componentes usam o prefixo <code class="bg-gray-100 dark:bg-white/10 dark:text-slate-300 px-1 rounded">x-jetax-</code>.
            Veja alguns exemplos:
        </p>

        <div class="space-y-4">
            <div>
                <p class="text-sm font-medium text-gray-700 dark:text-white/60 mb-2">Botão</p>
                <pre class="bg-gray-900 text-gray-100 rounded-xl p-4 text-sm"><code>&lt;x-jetax-button color="primary"&gt;Clique aqui&lt;/x-jetax-button&gt;

&lt;x-jetax-button style="outline" color="success" icon="save"&gt;
    Salvar
&lt;/x-jetax-button&gt;</code></pre>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-700 dark:text-white/60 mb-2">Formulário com validação Livewire</p>
                <pre class="bg-gray-900 text-gray-100 rounded-xl p-4 text-sm"><code>&lt;form wire:submit="save"&gt;
    &lt;x-jetax-input
        label="Nome completo"
        wire:model="name"
        :error="$errors->first('name')"
        required
    /&gt;

    &lt;x-jetax-select
        label="Status"
        :options="['ativo' =&gt; 'Ativo', 'inativo' =&gt; 'Inativo']"
        wire:model="status"
    /&gt;

    &lt;x-jetax-button type="submit" :loading="$isLoading"&gt;
        Salvar
    &lt;/x-jetax-button&gt;
&lt;/form&gt;</code></pre>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-700 dark:text-white/60 mb-2">Alerta de feedback</p>
                <pre class="bg-gray-900 text-gray-100 rounded-xl p-4 text-sm"><code>&#64;if(session('status'))
    &lt;x-jetax-alert
        variant="success"
        :message="session('status')"
        dismissible
    /&gt;
&#64;endif</code></pre>
            </div>
        </div>
    </section>

    {{-- Próximos passos --}}
    <section>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">Próximos passos</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="/docs/customization"
               class="bg-white dark:bg-[rgb(22,27,42)] rounded-xl border border-gray-200 dark:border-white/5 p-5 hover:border-blue-300 dark:hover:border-[#60b4ff]/30 hover:shadow-sm transition-all">
                <div class="font-medium text-gray-900 dark:text-[#e2e8f0] mb-1">Customização →</div>
                <div class="text-sm text-gray-500 dark:text-white/45">Aprenda a customizar temas e publicar configurações.</div>
            </a>
            <a href="/docs/components/button"
               class="bg-white dark:bg-[rgb(22,27,42)] rounded-xl border border-gray-200 dark:border-white/5 p-5 hover:border-blue-300 dark:hover:border-[#60b4ff]/30 hover:shadow-sm transition-all">
                <div class="font-medium text-gray-900 dark:text-[#e2e8f0] mb-1">Ver Componentes →</div>
                <div class="text-sm text-gray-500 dark:text-white/45">Explore todos os componentes disponíveis.</div>
            </a>
        </div>
    </section>
</x-jetax-docs-layout>
