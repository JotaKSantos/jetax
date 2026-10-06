# Changelog

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/),
e este projeto adere ao [Versionamento Semântico](https://semver.org/lang/pt-BR/).

## [2.0.0] - 2026-10-06

Versão major: alinha o pacote à paleta e aos mockups do VetSoft e absorve a API que as
aplicações só tinham em views publicadas. Os itens marcados com **[BREAKING]** quebram a API
da 1.x; o passo a passo de cada um está no guia de migração [`UPGRADE.md`](UPGRADE.md).

### Added
- **Chip (JETAX-021):** novo `<x-jetax-chip>` de exibição, sem estado próprio. Rótulo por prop `label` ou slot; `removable` renderiza o `×` num `<button>` que recebe os atributos de remoção do consumidor (ex.: `wire:click`)
- **Tag input (JETAX-021):** novo `<x-jetax-tag-input>`, com o comportamento e a API do antigo `x-jetax-tag` (`suggestions`, `max`, `disabled`)
- **Button group (JETAX-022):** novo `<x-jetax-button-group split>`, que agrupa ação principal e gatilho de dropdown numa moldura só (raios internos zerados, divisória entre segmentos, altura propagada ao gatilho)
- **Page header (JETAX-005, JETAX-013):** slot `titleAfter` colado à direita do título; prop `icon` com o quadrado de 44px em gradiente `primary-container` e título 26px/700; `heading="h1"` (padrão `h2`); `subtitle-beside-icon`
- **Button (JETAX-014 a, b):** prop `icon-only` (quadrado sm 32px, md 44px, lg 48px, exige `aria-label` ou `title` quando o slot está vazio) e `color="custom"` com `color-token="<token>"`, que pinta o fundo com `var(--color-<token>)`
- **Pagination (JETAX-015):** prop `livewire`, que troca cada `href` de página por `<button type="button" wire:click="gotoPage(N, '<pageName>')">` com as mesmas classes
- **Table (JETAX-023):** colunas aceitam `align`, `width`, `class`, `thClass` e `attributes` (inclusive `data-*`); slot `cell-<key>` para conteúdo rico; com `paginator`, a ordenação só emite o evento `sort` (`{key, direction}`)
- **Popover (JETAX-024):** prop `:open` controlada pelo servidor e evento `close` no clique fora ou Esc
- **Stats card (JETAX-019, JETAX-025):** prop `tone` (`neutral`, `success`, `danger`, `warning`, `info`), `layout="figure"` (fundo sólido do tom, ícone translúcido à esquerda, valor acima do rótulo) e `hint`
- **Modal (JETAX-026):** prop `level` (inteiro ≥ 1) que empilha modais aumentando o z-index; attribute bag e `class` chegam ao painel
- **Editor (JETAX-027):** `readonly` sem esmaecer, `without-link`, `data-editor-key` e evento de janela `editor-insert` com `{editor, text}`, que insere o texto na seleção salva
- **Timeline item (JETAX-028):** slot `marker-overlay`, renderizado em `<span data-jetax-timeline-marker-overlay>` no canto do medalhão, nos ramos vertical e horizontal
- **Topbar (JETAX-012):** slot `leftActions` e props `sidebar-width`/`collapsed-width` para a largura da sidebar expandida e recolhida
- **Dialog:** corpo livre por slot, slot `footer`, `confirm-disabled`, `panel-width="narrow"` e âncoras `data-dialog-cancel`/`data-dialog-confirm`
- **Dropdown (JETAX-004):** posições `top-start` e `top-end`, além de `bottom-start` e `bottom-end`
- **Config:** chave `jetax.animations` (padrão `true`). Com `false`, `dialog`, `modal`, `dropdown` e `popover` não emitem `x-transition`, e as classes `jetax-animate-fade-*`/`jetax-animate-slide-*` deixam de animar (`shimmer` e `spin` continuam)
- **Tokens:** `--color-success-text`, `--color-primary-deep` e os tons sólidos `--color-danger-solid`, `--color-success-solid`, `--color-neutral-solid` e `--color-warning-solid`, declarados nos dois temas
- **Validação:** trait `Concerns\ValidatesVariant`, usada por `Badge`, `Alert`, `Button`, `Dropdown` e `StatsCard`

### Changed
- **[BREAKING] Topbar sem busca (JETAX-012):** o campo "Pesquisar..." embutido saiu; a barra usa `bg-sidebar` nos dois temas, com borda inferior sempre presente. Ver [UPGRADE.md](UPGRADE.md#quebra-topbar-sem-busca)
- **[BREAKING] Validação de variante, cor e posição (JETAX-010):** valores fora de `Badge::VARIANTS`, `Alert::VARIANTS`, `Button::COLORS` e `Dropdown::POSITIONS` lançam `InvalidArgumentException` em `local`/`testing` e caem no valor padrão com `Log::warning` nos demais ambientes. No `badge`, `color` vira alias de `variant` e não vaza mais como atributo HTML. Ver [UPGRADE.md](UPGRADE.md#quebra-validacao-de-variante)
- **[BREAKING] Altura dos campos 44px → 40px (JETAX-018):** `input` e `select` medem 40px pela classe `h-10`, sem `style="height:"` inline. Ver [UPGRADE.md](UPGRADE.md#quebra-altura-dos-campos)
- **[BREAKING] Tokens trocados (JETAX-006, JETAX-008):** os valores de `--color-*` nos dois temas seguem a paleta VetSoft (tabela T-1). Ver [UPGRADE.md](UPGRADE.md#quebra-tokens)
- **[BREAKING] Animações (RF-38):** as transições de `dialog`, `modal`, `dropdown` e `popover` passam a depender de `jetax.animations`, e os layouts do pacote marcam o `<html>` com `data-jetax-animations="off"` quando ela está desligada. Ver [UPGRADE.md](UPGRADE.md#quebra-animacoes)
- **Dropdown (JETAX-004):** o menu passa a ser `fixed`, posicionado pelo retângulo do gatilho, sem teleporte; troca de lado quando não cabe e reposiciona em scroll/resize. O wrapper do gatilho tem `h-full`
- **Rótulos (JETAX-007, JETAX-018):** rótulos de `input`, `select`, `textarea`, `time`, `form-group` e `currency` e a barra do `editor` usam `text-on-surface-variant`; o rótulo dos campos mede 11px, peso 700 e espaçamento `.06em`
- **Stats card, modal, card e checkbox:** superfícies, rótulos e estados por token, sem `bg-white`, `slate-*` nem hex literal

### Fixed
- **Alert (JETAX-001):** `class` do consumidor gerava dois atributos `class` na raiz; agora sai um só, mesclado, nos estilos `soft`, `solid` e `rich`
- **Toggle (JETAX-002):** `wire:model` (e `wire:model.*`) não gravava a propriedade; agora lê por `$wire.get()`, grava por `$wire.$set()` respeitando `.live` e reflete mudança vinda do servidor sem `wire:key`
- **Currency (JETAX-003):** `wire:model` não gravava o valor bruto nem esvaziava quando o servidor mudava a propriedade; agora grava por `$wire.$set()` e reidrata por `x-effect`
- **Dropdown (JETAX-004):** menu recortado dentro de ancestral com `overflow-hidden`/`overflow-x-auto`
- **Dark mode (JETAX-006, JETAX-008):** `on-surface`, `success` e `danger` do tema escuro com contraste abaixo de 4,5:1
- **Rótulos (JETAX-007):** cor fixa `text-[#…]` nos rótulos dos campos, ilegível no tema escuro
- **Autofill (JETAX-009):** `:-webkit-autofill` pintava o campo de amarelo/claro e o `<option>` do `<select>` vinha claro no tema escuro; o `jetax.css` agora pinta os dois com os tokens do tema
- **Badge (JETAX-010):** `color="danger"` era ignorado e vazava como atributo HTML
- **Card (JETAX-016):** classes de padding (`p-*`, `px-*`, `py-*`, com prefixo responsivo) eram anuladas por `style="padding:"`; agora valem no wrapper do conteúdo
- **Campos (JETAX-018):** `class` passada a `input`, `select` e `textarea` não chegava ao campo; o erro usava `bg-red-50` literal
- **Checkbox (JETAX-020):** `class` não chegava ao `<input>`; estado marcado com hex literal
- **Stats card (JETAX-019):** superfície, rótulo e tendência com paleta nomeada (`bg-white`, `text-slate-*`, `bg-green-50`)
- **Popover (JETAX-024):** painel recortado por ancestral com `overflow` e sem controle de abertura pelo servidor
- **Editor (JETAX-027):** abria vazio com valor vindo de `wire:model` ou `value` e não reidratava; o botão de link usava `prompt()`

### Removed
- **[BREAKING] `x-jetax-tag` (JETAX-021):** o componente e a classe `Tag` saíram; use `<x-jetax-tag-input>`, com a mesma API. Ver [UPGRADE.md](UPGRADE.md#quebra-tag-input)
- **[BREAKING] `Dropdown::menuPositionClasses()` (JETAX-004):** substituído por `vertical()` e `horizontal()`, que o menu `fixed` usa para se posicionar. Ver [UPGRADE.md](UPGRADE.md#quebra-dropdown-menu-position-classes)
- **[BREAKING] `jetax.colors` e `jetax.primary_color` (JETAX-011):** as chaves eram publicadas mas nenhum componente as lia; a paleta se troca por CSS. Ver [UPGRADE.md](UPGRADE.md#quebra-jetax-colors)

### Adiadas (v3.0)
- **JETAX-017** (inteira): a folha do Material Symbols entra sem cascade layer. A troca do sistema de ícones substitui essa folha, então o conserto fica para a fatia de ícones
- **JETAX-014(c)**: tamanho do glifo acompanhando o `size` do botão. Depende da métrica do glifo e será calibrado junto com a troca do sistema de ícones

## [1.1.2] - 2026-05-14

### Fixed
- **DataTable:** `applyPagination()` agora chama `->withPath(url()->current())` — sem isso, `$paginator->url(1)` retornava um caminho relativo (ex: `admin/tenants?page=1`) e o `window.location.href` resolvia relativo ao diretório atual, causando path duplicado (`/admin/admin/tenants` → 404)
- **DataTable:** `applyPagination()` agora chama `->appends(['per_page' => $perPage])` — sem isso, `per_page=` não estava na URL inicial e o regex do `onchange` (que procura `per_page=X` para substituir) nunca encontrava o parâmetro, fazendo a primeira troca de "Linhas por página" não ter efeito

## [1.1.1] - 2026-05-14

### Fixed
- **DataTable:** parâmetro de URL do seletor "Linhas por página" corrigido de `perPage` para `per_page` — o regex do JS em `pagination.blade.php` procurava `per_page=`, então o replace nunca encontrava o parâmetro e a mudança de itens por página não tinha efeito
- **DataTable:** default `per_page` no config alterado de `15` para `10` — 15 não está entre as opções do seletor (`[10, 25, 50, 100]`), fazendo com que nenhuma opção ficasse visualmente selecionada na carga inicial

## [1.1.0] - 2026-05-08

### Added
- Card: props `headerClass` e `footerClass` para o consumidor sobrescrever classes do header/footer sem reimplementar o componente
- Card: método público `footerClasses()` (paridade com `headerClasses()`)
- CSS: `@custom-variant dark (&:where(.dark, .dark *))` no `jetax.css` — habilita class-based dark mode no pacote, sem depender da app consumidora declarar

### Changed
- **Tokens CSS:** removido bloco `:root { --jetax-* }` (42 tokens duplicados, sem uso). `:root.dark` agora sobrescreve `--color-*` em vez de `--jetax-*`, fazendo classes Tailwind (`bg-primary`, `text-on-surface`, etc.) responderem ao tema automaticamente
- **Dark mode redesenhado** alinhado ao design CRM SoftD:
  - `--color-primary`/`--color-secondary` em dark passam a `#0D99FF` (azul vívido) em vez de `#00497e` (escuro/invisível)
  - `--color-on-surface` em dark `#e2e8f0`, `--color-on-surface-variant` `rgba(255,255,255,0.45)`
  - `--color-surface` `#0F121B`, `--color-surface-container-low/container` `#161B2A`, `--color-surface-container-high` `#1E2337`
  - `--color-outline`/`--color-outline-variant` em dark passam a usar `rgba(255,255,255,0.07/0.08)`
  - Status (success/warning/info/danger) em dark voltam aos tons claros padrão (`#4ade80`/`#fbbf24`/`#60c5ff`/`#f87171`)
- **Card:** novo look "dashboard moderno"
  - Light: `bg-white shadow-sm shadow-[#111A37]/5`
  - Dark: `bg-[#161B2A] shadow-lg shadow-black/20 border border-white/[0.05]`
  - Header com tipografia `flex items-center gap-2 font-headline font-bold text-sm uppercase tracking-wide`, cores `text-secondary` (light) / `text-primary` (dark) e separador inferior sutil
  - Featured: `text-error` + `border-b border-error/20`
  - Header passa a renderizar o slot direto (sem wrapper `<span>`), permitindo ícones inline
- **Topbar:** alinhada com a sidebar e com o design CRM
  - Em dark, bg igualado ao sidebar via `dark:bg-sidebar/80`
  - Search input usa `bg-surface-container-high`
  - Hover dos botões (fullscreen, notif, dark-toggle, profile) e do hamburger usa `bg-surface-container-high` (em vez de `-low`)
  - Ícones e textos secundários usam `dark:text-slate-400` (mesma cor dos itens não-ativos da sidebar); search input texto digitado `dark:text-slate-200`
  - Notification dot ring acompanha bg do header em cada modo (`ring-surface-container-lowest dark:ring-sidebar`)
- **Componentes do DS migrados para tokens** (removidos `bg-white` sólidos, `bg-slate-*`, `bg-gray-*`, `border-slate-*` e hex hardcodes legacy `#e2e6f1`, `#f3f3ff`, `#3d3d4e`, `#0061a5`):
  - Containers elevados (`dialog`, `dropdown`, `popover`, `tag` dropdown, `modal`) → `bg-surface-container-high`
  - Containers de superfície (`table`, `data-table`, `card`, `accordion`) → `bg-surface-container-lowest`; striped rows e hovers em `bg-surface-container-low`/`bg-surface-container`
  - Inputs (`input`, `textarea`, `pin`, `color`, `tag` field, `pagination`) → `bg-surface-input` + `border-outline-variant` + tokens de focus
  - Acessórios visuais (`timeline`, `activity-feed`, `upload`, `step-item`, `clipboard`, `offcanvas`, `docs-layout`, `docs-preview-section`, `carousel`) → tokens equivalentes
- `docs-layout`: `<body>` ganha `text-on-surface font-body antialiased` para evitar que texto herde `color: rgb(0,0,0)` (preto invisível) em dark mode

### Fixed
- Dark mode dos componentes responde corretamente via classes Tailwind — antes, hardcodes `dark:text-[#60b4ff]`/`dark:bg-[rgb(30,35,55)]` espalhados pelos blades supriam a falta de overrides em `--color-*`. Removidos
- Texto preto invisível em dark mode dentro de cards/preview-sections corrigido (raiz: body sem `text-on-surface`)

### Removed
- 42 tokens `--jetax-*` (duplicação pura — `var(--jetax-*)` nunca foi consumido em lugar algum do pacote)

## [1.0.0] - 2026-04-13

### Added
- Scaffold: Layout principal (`x-jetax-layout`), Auth Layout, Sidebar, Topbar, Page Header
- Dark Mode: Toggle com estratégia `class` e script anti-FOUC
- Componentes de Botão: Button, Avatar
- Componentes de Navegação: Breadcrumbs, Tabs, Pagination, Dropdown
- Componentes de Formulário: Input, Select, Textarea, Checkbox, Radio, Toggle, Form Group, Color Picker, Currency, Pin/OTP, Range, Tag, Time, Upload, Editor (TipTap)
- Componentes de Feedback: Alert, Badge, Spinner, Skeleton, Progress, Toast
- Componentes de Overlay: Modal, Offcanvas, Tooltip, Popover, Dialog
- Componentes de Dados: Table, Card, Stats Card, List Group, Detail Summary, Activity Feed, Timeline, Accordion, Collapse, Empty State
- Integração Livewire: wire:model, wire:loading, dispatch de eventos
- Publicação: Grupos vendor:publish (config, views, assets, CSS source)
- Comando `jetax:check` para detectar views publicadas desatualizadas
- Helper `jetax_config()` para leitura de config
- Documentação preview via Orchestra Testbench com playground interativo
- Pipeline CI com cobertura de testes ≥ 80% via PCOV
