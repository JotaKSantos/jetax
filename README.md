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
- Icones via **Font Awesome Free 6.7.2** (webfont importada pelo consumidor) com componente `<x-jetax-icon>` — veja [Icones](#icones)

---

## Atualizando da 2.x

A 3.0.0 troca o sistema de icones para a webfont do Font Awesome Free: marcacao `<i>` com classes FA, `weight`/`fill` removidas, prop `variant`, `icon` em `[estilo:]nome`, import do Font Awesome no CSS da aplicacao em layer e sem CDN, e tamanhos recalibrados pela regra ÷ 1,35. O passo a passo esta no [guia de migracao 2.x → 3.0](UPGRADE.md#guia-2x-30), e a lista completa de mudancas no [CHANGELOG](CHANGELOG.md).

## Atualizando da 1.x

A 2.0.0 tem quebras de API (topbar sem busca, `tag` → `tag-input`, validacao de variante/cor/posicao, campos de 40px, tokens, `Dropdown::menuPositionClasses()`, animacoes e `jetax.colors`). O passo a passo esta no [guia de migracao 1.x → 2.0](UPGRADE.md), e a lista completa de mudancas no [CHANGELOG](CHANGELOG.md).

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

Instale o **Font Awesome Free** em versao exata (o Jetax nao carrega folha de icone; quem importa e a aplicacao):

```bash
npm install --save-exact @fortawesome/fontawesome-free@6.7.2
```

No seu `resources/css/app.css`, adicione os imports das fontes e do Font Awesome **antes de qualquer outro import**:

```css
/* 1. Google Fonts — deve vir PRIMEIRO, antes de qualquer outro @import */
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300;600;700;800&family=Inter:wght@400;500;600&display=swap');

/* 2. Font Awesome Free — em layer(base), antes do Tailwind */
@import "@fortawesome/fontawesome-free/css/all.min.css" layer(base);

/* 3. Tailwind CSS */
@import "tailwindcss";
```

> **Importante:** O import do Google Fonts precisa vir **antes** de `@import "tailwindcss"` e do import do Jetax. Quando colocado dentro de `jetax.css`, o Vite/Tailwind gera alertas de build por restricoes do CSS Modules.

> **Importante:** O Font Awesome entra com `layer(base)`, antes de `@import "tailwindcss"`. Fora de layer, a regra `.fa-solid { font-size: ... }` da folha vence as utilitarias (`text-[18px]`) e o tamanho do call site deixa de valer. As webfonts saem do `node_modules` no build do Vite — sem CDN nem kit.

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

/* Font Awesome Free — em layer(base), antes de @import "tailwindcss" */
@import "@fortawesome/fontawesome-free/css/all.min.css" layer(base);

@import "tailwindcss";

@import "../../vendor/jksantos/jetax/resources/css/jetax.css";
@source "../../vendor/jksantos/jetax/resources/views";
```

> **Importante:** O import do Google Fonts deve ser o **primeiro** `@import` do arquivo, e o do Font Awesome vem em seguida, em `layer(base)` e antes de `@import "tailwindcss"`. O Jetax nao inclui nenhum dos dois para evitar alertas de build gerados pelo Vite/Tailwind CSS ao processar URLs externas dentro de pacotes.

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

`checkbox` `radio` `color` `currency` `date` `input` `input-group` `input-select` `input-masks` `number` `password` `pin` `range` `tag-input` `time` `textarea` `toggle` `select` `upload` `validation` `editor`

### Interface (UI)

`accordion` `alert` `avatar` `back-to-top` `badge` `breadcrumb` `button` `button-group` `card` `chip` `carousel` `collapse` `clipboard` `dismissible` `dropdown` `icon` `modal` `list-group` `loading` `popover` `progress` `pagination` `rating` `skeleton` `slide` `step` `tab` `table` `tooltip`

### Interacoes

`dialog` `toast`

### Componentes novos na 2.0

| Componente | Descricao |
|------------|-----------|
| `<x-jetax-chip label removable>` | Selo de exibicao sem estado. Rotulo por prop ou slot; `removable` mostra o `×` num `<button>` que recebe os atributos de remocao (ex.: `wire:click`) |
| `<x-jetax-tag-input>` | Campo de entrada de tags (antigo `x-jetax-tag`), com `suggestions`, `max` e `disabled` |
| `<x-jetax-button-group split>` | Agrupa um `x-jetax-button` e um `x-jetax-dropdown` numa moldura so, com divisoria e raios internos zerados |

```blade
<x-jetax-button-group split>
    <x-jetax-button>Salvar</x-jetax-button>
    <x-jetax-dropdown position="bottom-end">
        <x-slot:trigger><x-jetax-button icon-only aria-label="Mais opcoes">…</x-jetax-button></x-slot:trigger>
        <x-jetax-dropdown-item>Salvar e novo</x-jetax-dropdown-item>
    </x-jetax-dropdown>
</x-jetax-button-group>

<x-jetax-chip label="Situacao: Quitado" removable wire:click="limparFiltro('situacao')" />
```

> Todos os componentes usam o prefixo `<x-jetax-*>`. Exemplo: `<x-jetax-button>`, `<x-jetax-alert>`.

---

## Icones

Os icones sao da webfont do **Font Awesome Free 6.7.2**. O pacote emite a marcacao (`<i class="fa-solid fa-paw" aria-hidden="true"></i>`) e nao carrega folha nenhuma: instale e importe o Font Awesome no CSS da aplicacao, em layer, como na [instalacao](#pre-requisitos):

```bash
npm install --save-exact @fortawesome/fontawesome-free@6.7.2
```

```css
@import "@fortawesome/fontawesome-free/css/all.min.css" layer(base);
@import "tailwindcss";
```

### Nome do icone: `[estilo:]nome`

O `name` de `<x-jetax-icon>` e a prop `icon` dos componentes (button, alert, input, dropdown-item, page-header, empty-state, timeline-item, stats-card, list-group-item, activity-feed-item, `ActionsColumn`, `BulkAction::icon()` e `navigation` do config) recebem o nome canonico do Font Awesome, sem o `fa-`, com prefixo de estilo opcional:

| Valor | Classes emitidas |
|-------|------------------|
| `bell` | `fa-solid fa-bell` (sem prefixo vale `solid`) |
| `regular:bell` | `fa-regular fa-bell` |
| `brands:whatsapp` | `fa-brands fa-whatsapp` |

Prefixo fora de `solid|regular|brands` lanca `InvalidArgumentException` em `local`/`testing` e cai para `solid` com `Log::warning` nos demais ambientes. Os nomes validos estao no manifesto `resources/icons/fontawesome-free.json`.

```blade
<x-jetax-button icon="regular:bell">Avisos</x-jetax-button>
<x-jetax-alert icon="brands:whatsapp">Mensagem enviada</x-jetax-alert>
```

### `variant`

`<x-jetax-icon>` aceita `variant="solid|regular|brands"` (default `solid`). Com prefixo no `name`, o `variant` e opcional; se os dois forem informados e divergirem, vale a regra de variante invalida acima.

```blade
<x-jetax-icon name="bell" variant="regular" />
<x-jetax-icon name="regular:bell" />   {{-- equivalente --}}
```

### Tamanhos

| `size` | Saida |
|--------|-------|
| `sm` | `text-[12px]` |
| `md` (default) | `text-[15px]` |
| `lg` | `text-[18px]` |
| `xl` | `text-[24px]` |
| `<n>` (numerico) | `style="font-size:<m>px"`, com `<m>` = `<n>` ÷ 1,35 arredondado (ex.: `size="27"` → `20px`) |

O fator 1,35 converte o tamanho da v2 (16/20/24/32 px) para o equivalente visual do Font Awesome. O glifo do `<x-jetax-button>` acompanha o `size` do botao: `sm` → `text-[12px]`, `md` → `text-[14px]`, `lg` → `text-[18px]`.

### Troca de icone no cliente

Para trocar o icone com Alpine, use binding de classe, nunca `x-text`/`x-html` no elemento do icone:

```blade
<i class="fa-solid" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" aria-hidden="true"></i>
```

---

## Animacoes

A chave `jetax.animations` (padrao `true`) liga as transicoes de `dialog`, `modal`, `dropdown` e `popover`. Com `false`, eles abrem e fecham sem `x-transition`, os layouts do pacote marcam o `<html>` com `data-jetax-animations="off"` e as classes `jetax-animate-fade-*`/`jetax-animate-slide-*` param. `shimmer` e `spin` continuam animando.

```php
// config/jetax.php
'animations' => false,
```

---

## Dark Mode

O Jetax suporta dark mode nativo via estrategia `class` do Tailwind v4. A alternancia e gerenciada por Alpine.js com persistencia em `localStorage`. Um script anti-FOUC inline no `<head>` garante que o tema correto seja aplicado antes do primeiro render.

---

## Design Tokens

Os tokens de cor sao CSS custom properties `--color-*`, declarados via Tailwind v4 `@theme {}` (tema claro) e sobrescritos em `:root.dark {}` (tema escuro), com os mesmos nomes nos dois temas. Os valores seguem a paleta VetSoft:

| Token | Claro | Escuro |
|---|---|---|
| `primary` | `#00548d` | `#4aa8e8` |
| `success` | `#00a05e` | `#00a05e` |
| `surface` | `#eef3f7` | `#061726` |
| `surface-container-lowest` | `#ffffff` | `#0b2334` |
| `on-surface` | `#0e2c42` | `#eef4f9` |
| `danger-solid` | `#c0392b` | `#96331f` |

A lista completa esta em `resources/css/jetax.css`. Os tons `*-solid` (`danger-solid`, `success-solid`, `neutral-solid`, `warning-solid`) sao fundos para texto branco, com contraste WCAG >= 4,5:1.

### Trocar a paleta por CSS

A paleta **nao** e configurada em `config/jetax.php`: a chave `colors` foi removida na v2.0.0, porque nenhum componente a lia. Para trocar uma cor, sobrescreva a variavel `--color-*` no CSS da aplicacao, **depois** do `@import` do `jetax.css`, nos dois temas:

```css
@import "../../vendor/jksantos/jetax/resources/css/jetax.css";

:root {
    --color-primary: #7c3aed;
    --color-primary-container: #6d28d9;
}

:root.dark {
    --color-primary: #a78bfa;
    --color-primary-container: #5b21b6;
}
```

Todas as classes que consomem o token (`bg-primary`, `text-primary`, `border-primary`, `from-primary-container` etc.) passam a usar o novo valor, sem republicar views. Para manter o contraste, troque cada token junto com o seu par (`on-surface` com `surface`, texto branco com os tons `*-solid`).

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
