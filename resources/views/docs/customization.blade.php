<x-jetax-docs-layout title="Customização — Jetax">
    <div class="mb-8">
        <nav class="text-sm text-gray-500 dark:text-white/45 mb-4">
            <a href="/docs" class="hover:text-blue-600 dark:hover:text-[#60b4ff]">Docs</a>
            <span class="mx-2">›</span>
            <span class="text-gray-800 dark:text-[#e2e8f0]/80">Customização</span>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-[#e2e8f0] mb-2">Customização</h1>
        <p class="text-lg text-gray-600 dark:text-white/60">
            Aprenda a adaptar o Jetax ao seu projeto — de configurações simples ao override completo de views.
        </p>
    </div>

    {{-- Publicar configuração --}}
    <section class="mb-10">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">1. Publicar a configuração</h2>
        <p class="text-gray-600 dark:text-white/60 mb-3">
            Execute o comando abaixo para copiar o arquivo de configuração para o seu projeto:
        </p>
        <pre class="bg-gray-900 text-green-400 rounded-xl p-4 text-sm"><code>php artisan vendor:publish --tag=jetax-config</code></pre>
        <p class="text-gray-600 dark:text-white/60 mt-3">
            O arquivo será publicado em <code class="bg-gray-100 dark:bg-white/10 dark:text-slate-300 px-1 rounded">config/jetax.php</code>.
        </p>
    </section>

    {{-- Arquivo de configuração --}}
    <section class="mb-10">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">2. config/jetax.php</h2>
        <p class="text-gray-600 dark:text-white/60 mb-3">
            O arquivo de configuração controla o comportamento global do Jetax:
        </p>
        <pre class="bg-gray-900 text-gray-100 rounded-xl p-4 text-sm"><code>&lt;?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cor primária do design system
    |--------------------------------------------------------------------------
    | Define a cor padrão usada nos componentes que não especificam cor.
    | Exemplos: 'primary', 'blue', 'indigo'
    */
    'default_color' =&gt; 'primary',

    /*
    |--------------------------------------------------------------------------
    | Prefixo dos componentes
    |--------------------------------------------------------------------------
    | Prefixo aplicado a todos os componentes Blade.
    | Padrão: 'jetax' → &lt;x-jetax-button&gt;
    */
    'prefix' =&gt; 'jetax',

    /*
    |--------------------------------------------------------------------------
    | Tema padrão
    |--------------------------------------------------------------------------
    | Tema inicial da aplicação: 'light' ou 'dark'
    */
    'theme' =&gt; 'light',

    /*
    |--------------------------------------------------------------------------
    | Fonte padrão
    |--------------------------------------------------------------------------
    | Nome da família de fonte padrão (usada nas classes Tailwind).
    */
    'font_family' =&gt; 'Inter',

    /*
    |--------------------------------------------------------------------------
    | Componentes habilitados
    |--------------------------------------------------------------------------
    | Lista dos componentes que serão registrados.
    | Use 'all' para registrar todos, ou liste apenas os que deseja.
    */
    'components' =&gt; 'all',
];</code></pre>

        <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-500/10 rounded-lg border border-yellow-200 dark:border-yellow-500/20">
            <p class="text-sm text-yellow-800 dark:text-yellow-300">
                <strong>Dica:</strong> Você pode ler os valores da configuração no seu código com a função auxiliar
                <code class="bg-yellow-100 dark:bg-yellow-900/30 px-1 rounded">jetax_config('default_color')</code>
                ou com o helper padrão do Laravel
                <code class="bg-yellow-100 dark:bg-yellow-900/30 px-1 rounded">config('jetax.default_color')</code>.
            </p>
        </div>
    </section>

    {{-- Publicar views --}}
    <section class="mb-10">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">3. Override de views (vendor:publish)</h2>
        <p class="text-gray-600 dark:text-white/60 mb-3">
            Para customizar o HTML/Blade de qualquer componente, publique as views:
        </p>
        <pre class="bg-gray-900 text-green-400 rounded-xl p-4 text-sm"><code>php artisan vendor:publish --tag=jetax-views</code></pre>
        <p class="text-gray-600 dark:text-white/60 mt-3 mb-3">
            Os arquivos serão copiados para
            <code class="bg-gray-100 dark:bg-white/10 dark:text-slate-300 px-1 rounded">resources/views/vendor/jetax/</code>.
            Qualquer arquivo publicado aqui sobrescreverá a view original do pacote.
        </p>

        <div class="bg-white dark:bg-[rgb(22,27,42)] rounded-xl border border-gray-200 dark:border-white/5 overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 dark:bg-[rgb(28,34,52)] border-b border-gray-200 dark:border-white/[0.07] text-sm font-medium text-gray-600 dark:text-white/60">
                Estrutura após o publish
            </div>
            <pre class="p-4 text-sm text-gray-700 dark:text-white/60"><code>resources/
└── views/
    └── vendor/
        └── jetax/
            ├── components/
            │   ├── button.blade.php       ← customizar aqui
            │   ├── alert.blade.php
            │   ├── input.blade.php
            │   └── ...
            └── partials/
                └── ...</code></pre>
        </div>
    </section>

    {{-- CSS customizado --}}
    <section class="mb-10">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">4. Customizar o CSS</h2>
        <p class="text-gray-600 dark:text-white/60 mb-3">
            Publique os arquivos CSS fonte para modificar variáveis de design:
        </p>
        <pre class="bg-gray-900 text-green-400 rounded-xl p-4 text-sm"><code>php artisan vendor:publish --tag=jetax-css-source</code></pre>
        <p class="text-gray-600 dark:text-white/60 mt-3 mb-3">
            Os arquivos serão copiados para
            <code class="bg-gray-100 dark:bg-white/10 dark:text-slate-300 px-1 rounded">resources/css/vendor/jetax/</code>.
            Você pode customizar os tokens de design (cores, tipografia, espaçamentos) nos arquivos de variáveis CSS.
        </p>

        <div class="bg-white dark:bg-[rgb(22,27,42)] rounded-xl border border-gray-200 dark:border-white/5 overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 dark:bg-[rgb(28,34,52)] border-b border-gray-200 dark:border-white/[0.07] text-sm font-medium text-gray-600 dark:text-white/60">
                Exemplo — customizar cores primárias
            </div>
            <pre class="p-4 text-sm text-gray-700 dark:text-white/60"><code>/* resources/css/vendor/jetax/variables.css */
:root {
    --color-primary: #6366f1;      /* Indigo */
    --color-primary-hover: #4f46e5;
    --color-secondary: #8b5cf6;    /* Violet */
}</code></pre>
        </div>
    </section>

    {{-- Publicar tudo --}}
    <section class="mb-10">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-[#e2e8f0] mb-4">Publicar tudo de uma vez</h2>
        <p class="text-gray-600 dark:text-white/60 mb-3">
            Para publicar todos os recursos do Jetax em uma única operação:
        </p>
        <pre class="bg-gray-900 text-green-400 rounded-xl p-4 text-sm"><code>php artisan vendor:publish --provider="Jetax\DesignSystem\JetaxServiceProvider"</code></pre>
    </section>

    <div class="p-6 bg-gray-50 dark:bg-[rgb(22,27,42)] rounded-xl border border-gray-200 dark:border-white/5">
        <h3 class="font-semibold text-gray-800 dark:text-[#e2e8f0] mb-2">Precisa de mais controle?</h3>
        <p class="text-sm text-gray-600 dark:text-white/60 mb-3">
            Para personalizações profundas, consulte os componentes individuais na documentação.
            Cada componente lista todas as props e slots disponíveis.
        </p>
        <a href="/docs" class="text-sm text-blue-600 dark:text-[#60b4ff] hover:underline">← Ver todos os componentes</a>
    </div>
</x-jetax-docs-layout>
