<p align="center">
  <img src="https://img.shields.io/badge/Jetax-Design%20System-0061a5?style=for-the-badge&labelColor=141A30" alt="Jetax Design System">
</p>

<p align="center">
  <strong>Design System opinativo para TALL Stack — TailwindCSS, Alpine.js, Laravel e Livewire.</strong>
</p>

<p align="center">
  <a href="https://packagist.org/packages/jksantos/jetax"><img src="https://img.shields.io/packagist/v/jksantos/jetax?style=flat-square" alt="Latest Version"></a>
  <a href="https://packagist.org/packages/jksantos/jetax"><img src="https://img.shields.io/packagist/dt/jksantos/jetax?style=flat-square" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/jksantos/jetax"><img src="https://img.shields.io/packagist/l/jksantos/jetax?style=flat-square" alt="License"></a>
  <img src="https://img.shields.io/badge/PHP-8.4%2B-777BB4?style=flat-square&logo=php" alt="PHP 8.4+">
  <img src="https://img.shields.io/badge/Laravel-12%2B-FF2D20?style=flat-square&logo=laravel" alt="Laravel 12+">
  <img src="https://img.shields.io/badge/Livewire-4%2B-FB70A9?style=flat-square" alt="Livewire 4+">
  <img src="https://img.shields.io/badge/Tailwind-4%2B-06B6D4?style=flat-square&logo=tailwindcss" alt="Tailwind 4+">
</p>

---

## Sobre o Jetax

**Jetax** (`jksantos/jetax`) é um pacote Composer que entrega um design system completo para a TALL Stack. Instale um comando, rode o instalador, e tenha imediatamente sidebar, topbar, workspace e 60+ componentes Blade/Livewire prontos para uso.

### Por que Jetax?

- Componentes construídos nativamente para **Livewire v4** com props, attributes e slots
- Design system coeso com dark mode nativo e script anti-FOUC
- Totalmente publicável — customize qualquer view, config ou asset via `vendor:publish`
- AlpineJS carregado automaticamente via `@livewireScripts` — zero configuração extra
- Tipografia profissional com **Manrope** (headlines) e **Inter** (body)
- Icones via **Material Symbols Outlined** com componente `<x-jetax-icon>`

---

## Requisitos

| Dependencia | Versao |
|-------------|--------|
| PHP         | 8.4+   |
| Laravel     | 12+    |
| Livewire    | 4+     |
| Tailwind CSS| 4+     |
| Alpine.js   | 3+ (carregado pelo Livewire) |

---

## Instalacao

### Pre-requisitos

Antes de instalar o Jetax, seu projeto Laravel precisa ter o **Tailwind CSS 4+** configurado. Se ainda nao tiver:

```bash
# Instalar Tailwind CSS via npm
npm install -D tailwindcss @tailwindcss/vite

# Ou via yarn
yarn add -D tailwindcss @tailwindcss/vite
```

No seu `vite.config.js`, adicione o plugin:

```js
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

No seu `resources/css/app.css`, adicione os imports das fontes **antes de qualquer outro import**:

```css
/* 1. Google Fonts — deve vir PRIMEIRO, antes de qualquer outro @import */
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300;600;700;800&family=Inter:wght@400;500;600&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap');

/* 2. Tailwind CSS */
@import "tailwindcss";
```

> **Importante:** Os imports do Google Fonts e Material Symbols precisam vir **antes** de `@import "tailwindcss"` e do import do Jetax. Quando colocados dentro de `jetax.css`, o Vite/Tailwind gera alertas de build por restrições do CSS Modules.

> O **Livewire 4+** tambem e obrigatorio. Instale com `composer require livewire/livewire` caso nao tenha.

### 1. Instalar o pacote

```bash
composer require jksantos/jetax
```

O ServiceProvider e registrado automaticamente via Laravel Package Discovery. Todos os componentes `<x-jetax-*>` ficam disponiveis imediatamente.

### 2. Executar o instalador

```bash
php artisan jetax:install
```

O comando `jetax:install` publica o CSS source, configura o Tailwind e adiciona o `@import` necessario no seu arquivo CSS principal.

### 3. Configurar o CSS

No seu `resources/css/app.css`, adicione (caso o instalador nao tenha feito automaticamente):

```css
/* Google Fonts — SEMPRE antes de qualquer outro @import */
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300;600;700;800&family=Inter:wght@400;500;600&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap');

@import "../../vendor/jksantos/jetax/resources/css/jetax.css";
@source "../../vendor/jksantos/jetax/resources/views";
```

> **Importante:** Os imports do Google Fonts e Material Symbols Outlined devem ser os **primeiros** `@import` do arquivo. O Jetax nao os inclui diretamente para evitar alertas de build gerados pelo Vite/Tailwind CSS ao processar URLs externas dentro de pacotes.

### 4. Carregar Livewire no layout

No seu layout Blade principal:

```blade
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    {{-- Script anti-FOUC para dark mode (incluso no layout do Jetax) --}}
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{ $slot }}

    @livewireScripts {{-- Carrega Alpine.js automaticamente --}}
</body>
</html>
```

### 5. Pronto! Use os componentes

```blade
<x-jetax-layout>
    <x-slot:title>Clientes</x-slot:title>

    <x-jetax-page-header title="Clientes" subtitle="Gerenciar base de clientes">
        <x-jetax-button variant="primary">Novo cliente</x-jetax-button>
    </x-jetax-page-header>

    <x-jetax-card>
        <x-jetax-table :headers="['Nome', 'Email', 'Status']" :rows="$clientes" />
    </x-jetax-card>
</x-jetax-layout>
```

---

## Publicacao de Recursos

Publique apenas o que precisar customizar:

```bash
# Configuracao (tokens, fontes, breakpoints)
php artisan vendor:publish --tag=jetax-config

# Views dos componentes (para override)
php artisan vendor:publish --tag=jetax-views

# Assets compilados (CSS, fontes, icones)
php artisan vendor:publish --tag=jetax-assets

# CSS source (para customizacao com Tailwind v4)
php artisan vendor:publish --tag=jetax-css-source

# Tudo de uma vez
php artisan vendor:publish --provider="Jetax\DesignSystem\JetaxServiceProvider"
```

---

## Componentes

### Scaffold / Layout

| Componente | Descricao |
|------------|-----------|
| `<x-jetax-layout>` | Shell principal (sidebar + topbar + workspace) |
| `<x-jetax-sidebar>` | Navegacao lateral com active-pill indicator |
| `<x-jetax-topbar>` | Barra superior com glassmorphism |
| `<x-jetax-auth-layout>` | Layout para telas de autenticacao |
| `<x-jetax-page-header>` | Cabecalho de pagina com breadcrumb e acoes |

### Formularios

`checkbox` `radio` `color` `currency` `date` `input` `input-group` `input-select` `input-masks` `number` `password` `pin` `range` `tag` `time` `textarea` `toggle` `select` `upload` `validation` `editor`

### Interface (UI)

`accordion` `alert` `avatar` `back-to-top` `badge` `breadcrumb` `button` `card` `carousel` `collapse` `clipboard` `dismissible` `dropdown` `icon` `modal` `list-group` `loading` `popover` `progress` `pagination` `rating` `skeleton` `slide` `step` `tab` `table` `tooltip`

### Interacoes

`dialog` `toast`

> Todos os componentes usam o prefixo `<x-jetax-*>`. Exemplo: `<x-jetax-button>`, `<x-jetax-alert>`.

---

## Dark Mode

O Jetax suporta dark mode nativo via estrategia `class` do Tailwind v4. A alternancia e gerenciada por Alpine.js com persistencia em `localStorage`. Um script anti-FOUC inline no `<head>` garante que o tema correto seja aplicado antes do primeiro render.

---

## Design Tokens

Os tokens visuais sao definidos como CSS custom properties via Tailwind v4 `@theme {}`:

```
primary:          #00497e
secondary:        #0061a5
surface:          #FAF8FF
surface-card:     #FFFFFF
on-surface:       #111A37
sidebar:          #141A30
```

Dark mode aplica overrides em `:root.dark {}`. Customize via `config/jetax.php` apos publicacao.

---

## Desenvolvimento

O pacote e desenvolvido como pacote Composer independente, testado com Orchestra Testbench. O ambiente de desenvolvimento usa Docker:

```bash
cd packages/jksantos/jetax/

# Instalar dependencias
docker compose run --rm php composer install

# Rodar testes
docker compose run --rm php ./vendor/bin/pest

# Formatar codigo
docker compose run --rm php ./vendor/bin/pint --dirty

# Compilar assets
docker compose run --rm node npm run build
```

### Estrutura do Projeto

```
packages/jksantos/jetax/
├── src/                    # ServiceProvider, componentes PHP
├── resources/
│   ├── views/components/   # Templates Blade
│   └── css/                # CSS source com tokens
├── config/                 # jetax.php configuracao
├── tests/                  # Testes Pest + Orchestra Testbench
└── composer.json
```

---

## Licenca

Jetax e software open-source licenciado sob a [licenca MIT](https://opensource.org/licenses/MIT).
