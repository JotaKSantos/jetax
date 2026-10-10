<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Prefixo dos Componentes
    |--------------------------------------------------------------------------
    |
    | Define o prefixo utilizado para registrar os componentes Blade do Jetax.
    | Exemplo: <x-jetax-button /> com prefixo "jetax".
    |
    */
    'prefix' => 'jetax',

    /*
    |--------------------------------------------------------------------------
    | Fontes
    |--------------------------------------------------------------------------
    |
    | Define as famílias tipográficas utilizadas no design system.
    |
    */
    'fonts' => [
        'headline' => 'Manrope',
        'body' => 'Inter',
    ],

    /*
    |--------------------------------------------------------------------------
    | Fonte de Carregamento das Fontes
    |--------------------------------------------------------------------------
    |
    | Define como as fontes são carregadas:
    |   'google' — via Google Fonts CDN (padrão)
    |   'local'  — auto-hospedagem (desenvolvedor gerencia os @font-face)
    |   false    — desativa o carregamento automático de fontes
    |
    */
    'font_source' => 'google',

    /*
    |--------------------------------------------------------------------------
    | Border Radius
    |--------------------------------------------------------------------------
    |
    | Tokens de arredondamento de bordas utilizados nos componentes.
    |
    */
    'border_radius' => [
        'DEFAULT' => '0.125rem',
        'lg' => '0.25rem',
        'xl' => '0.5rem',
        'full' => '0.75rem',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cor de Fundo do Sidebar
    |--------------------------------------------------------------------------
    |
    | Cor de fundo utilizada no componente de sidebar da aplicação.
    |
    */
    'sidebar_background' => '#141A30',

    /*
    |--------------------------------------------------------------------------
    | Navegação do Sidebar
    |--------------------------------------------------------------------------
    |
    | Define os itens de navegação exibidos no sidebar.
    | Cada item pode conter: label, icon (Font Awesome Free em `[estilo:]nome`,
    | ex.: `house`, `regular:bell`, `brands:whatsapp`), route e url.
    |
    */
    'navigation' => [
        'main' => [
            ['label' => 'Dashboard', 'icon' => 'table-cells-large', 'route' => 'dashboard'],
            ['label' => 'Clientes', 'icon' => 'users', 'route' => 'clients.*'],
            ['label' => 'Projetos', 'icon' => 'briefcase', 'route' => 'projects.*'],
            ['label' => 'Tarefas', 'icon' => 'circle-check', 'route' => 'tasks.*'],
            ['label' => 'Faturamento', 'icon' => 'money-bills', 'route' => 'billing.*'],
            ['label' => 'Relatórios', 'icon' => 'chart-column', 'route' => 'reports.*'],
        ],
        'footer' => [
            ['label' => 'Configurações', 'icon' => 'gear', 'route' => 'settings'],
            ['label' => 'Sair', 'icon' => 'right-from-bracket', 'route' => 'logout'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Modo Escuro
    |--------------------------------------------------------------------------
    |
    | Estratégia de ativação do modo escuro.
    | Opções: 'class' | 'media'
    |
    */
    'dark_mode' => 'class',

    /*
    |--------------------------------------------------------------------------
    | Animações
    |--------------------------------------------------------------------------
    |
    | Liga ou desliga as transições de abertura e fechamento de dialog, modal,
    | dropdown e popover. Com false, esses componentes não emitem x-transition,
    | os layouts do pacote marcam o <html> com data-jetax-animations="off" e as
    | classes jetax-animate-fade-* e jetax-animate-slide-* deixam de animar.
    | shimmer e spin continuam animando (são indicadores de carregamento).
    |
    */
    'animations' => true,

    /*
    |--------------------------------------------------------------------------
    | Caminho dos Assets
    |--------------------------------------------------------------------------
    |
    | Caminho base dos assets publicados pelo pacote Jetax.
    |
    */
    'assets_path' => 'vendor/jetax',

    /*
    |--------------------------------------------------------------------------
    | Assets Vite
    |--------------------------------------------------------------------------
    |
    | Arquivos passados para @vite() nos layouts do Jetax.
    | Altere se sua aplicação usar paths diferentes dos padrões do Laravel.
    |
    */
    'vite_assets' => ['resources/css/app.css', 'resources/js/app.js'],
];
