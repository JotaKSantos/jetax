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
    | Cor Primária (legado)
    |--------------------------------------------------------------------------
    |
    | Mantida para compatibilidade com versões anteriores.
    | Utilize a chave 'colors.primary' para novas implementações.
    |
    */
    'primary_color' => '#00497e',

    /*
    |--------------------------------------------------------------------------
    | Paleta de Cores
    |--------------------------------------------------------------------------
    |
    | Tokens semânticos de cor do design system Jetax.
    | Baseados na especificação Material You adaptada para o Jetax.
    |
    */
    'colors' => [
        'primary'                    => '#00497e',
        'primary-container'          => '#0061a5',
        'primary-fixed'              => '#d2e4ff',
        'primary-fixed-dim'          => '#9fcaff',
        'primary-gradient'           => 'linear-gradient(135deg, #0061a5 0%, #0D99FF 100%)',
        'secondary'                  => '#0061a5',
        'secondary-container'        => '#0397fd',
        'secondary-fixed-dim'        => '#9fcaff',
        'tertiary'                   => '#40465e',
        'error'                      => '#ba1a1a',
        'error-container'            => '#ffdad6',
        'surface'                    => '#faf8ff',
        'surface-dim'                => '#d0d8ff',
        'surface-container-lowest'   => '#ffffff',
        'surface-container-low'      => '#f3f2ff',
        'surface-container'          => '#ebedff',
        'surface-container-high'     => '#e3e7ff',
        'surface-container-highest'  => '#dce1ff',
        'surface-input'              => '#f3f3ff',
        'on-surface'                 => '#111a37',
        'on-surface-variant'         => '#414750',
        'on-primary'                 => '#ffffff',
        'on-primary-fixed'           => '#001d36',
        'outline'                    => '#717782',
        'outline-variant'            => '#c1c7d2',
        'inverse-surface'            => '#262f4d',
    ],

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
        'body'     => 'Inter',
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
        'lg'      => '0.25rem',
        'xl'      => '0.5rem',
        'full'    => '0.75rem',
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
    | Cada item pode conter: label, icon (Material Symbols), route e url.
    |
    */
    'navigation' => [
        'main' => [
            ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'dashboard'],
            ['label' => 'Clientes', 'icon' => 'group', 'route' => 'clients.*'],
            ['label' => 'Projetos', 'icon' => 'work', 'route' => 'projects.*'],
            ['label' => 'Tarefas', 'icon' => 'task_alt', 'route' => 'tasks.*'],
            ['label' => 'Faturamento', 'icon' => 'payments', 'route' => 'billing.*'],
            ['label' => 'Relatórios', 'icon' => 'bar_chart', 'route' => 'reports.*'],
        ],
        'footer' => [
            ['label' => 'Configurações', 'icon' => 'settings', 'route' => 'settings'],
            ['label' => 'Sair', 'icon' => 'logout', 'route' => 'logout'],
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
