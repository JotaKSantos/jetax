# Changelog

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/),
e este projeto adere ao [Versionamento Semântico](https://semver.org/lang/pt-BR/).

## [4.0.0] - 2026-10-11

Versão major: alinha a **forma** dos componentes (raio, altura, padding, largura, borda, sombra,
glifo, caixa e cor de borda de estado) aos mockups do VetSoft no Claude Design. As divergências
medidas viraram as issues JETAX-029 a JETAX-047. Nenhuma chave existente de `SIZES`, `STYLES`,
`COLORS` ou `GLYPH_SIZES` foi removida, mas vários defaults visuais mudaram: os itens marcados com
**[BREAKING]** mudam a aparência ou o comportamento de quem usa a 3.x sem prop explícita, e o passo
a passo de cada um está no guia de migração [`UPGRADE.md`](UPGRADE.md#guia-3x-40).

### Changed
- **[BREAKING] Glifo do botão `md`: 14 → 15 px (JETAX-030):** `Button::GLYPH_SIZES['md']` passa de `text-[14px]` a `text-[15px]`, com e sem `icon-only`; `sm` (12 px) e `lg` (18 px) não mudam. Ver [UPGRADE.md](UPGRADE.md#v4-botao-glifo)
- **[BREAKING] Tamanhos e borda do botão (JETAX-029, JETAX-030):** `sm` vira `h-[34px]` com raio 8 px; `md` vira `h-11` (44 px) no `solid`/`soft` e `h-10` (40 px) com `px-[18px]` no `outline`; `lg` vira `h-[52px]` com raio 10 px; o só-ícone `sm` vira 34 px e o `md` ganha raio 10 px; a borda do `outline` passa de `border-2` a `border`; `size` inválido segue a regra de variante inválida. Ver [UPGRADE.md](UPGRADE.md#v4-botao-tamanhos)
- **[BREAKING] Recalibração de `Modal::SIZES` (JETAX-031):** `md` passa de `max-w-xl` (576 px) a `max-w-[560px]` e `lg` de `max-w-4xl` (896 px) a `max-w-[660px]`; o painel ganha raio 14 px e a sombra do mockup; `size` inválido segue a regra de variante inválida. Ver [UPGRADE.md](UPGRADE.md#v4-modal)
- **[BREAKING] Dialog (JETAX-032):** o painel de confirmação passa de `max-w-md` (448 px) a `max-w-[460px]`, e os painéis ganham raio 14 px, borda `border-outline-variant` e a sombra do modal. Ver [UPGRADE.md](UPGRADE.md#v4-dialog)
- **[BREAKING] Card (JETAX-033):** raio `rounded-xl` → `rounded-[10px]`, borda `border-outline-variant` nos dois temas e sem sombra no tema claro. Ver [UPGRADE.md](UPGRADE.md#v4-card)
- **[BREAKING] Table (JETAX-034):** contêiner com raio 14 px, borda `border-outline-variant` e sem a sombra inline; células `th` e `td` com `px-4 py-3.5`. Ver [UPGRADE.md](UPGRADE.md#v4-table)
- **[BREAKING] Badge (JETAX-035):** raio `rounded-full` → `rounded-[6px]`, `md` com `px-2 py-0.5 leading-[15px]` e estilo `status` sem borda. Ver [UPGRADE.md](UPGRADE.md#v4-badge)
- **[BREAKING] Select (JETAX-036):** altura 40 → 38 px, raio 8 px, `pl-2.5` e borda padrão `border-primary/18`. Ver [UPGRADE.md](UPGRADE.md#v4-select)
- **[BREAKING] Input (JETAX-037):** raio `rounded-lg` → `rounded-[8px]` e padding horizontal `px-4` → `px-3`. Ver [UPGRADE.md](UPGRADE.md#v4-input)
- **[BREAKING] Textarea (JETAX-038):** raio `rounded-lg` → `rounded-[8px]` e padding `px-4 py-3` → `p-2.5`. Ver [UPGRADE.md](UPGRADE.md#v4-textarea)
- **[BREAKING] Empty state (JETAX-039):** padding `p-12` → `px-5 py-10`. Ver [UPGRADE.md](UPGRADE.md#v4-empty-state)
- **[BREAKING] Checkbox (JETAX-040):** caixa `w-4 h-4` → `w-[15px] h-[15px]`. Ver [UPGRADE.md](UPGRADE.md#v4-checkbox)
- **[BREAKING] Chip (JETAX-041):** chip removível com `pl-[11px]` no lugar de `pl-3`. Ver [UPGRADE.md](UPGRADE.md#v4-chip)
- **[BREAKING] Dropdown (JETAX-042):** menu com `border border-outline-variant` no lugar do `ring-1`, sombra do mockup, raio 10 px e `p-1.5`. Ver [UPGRADE.md](UPGRADE.md#v4-dropdown)
- **[BREAKING] Dropdown item (JETAX-043):** `px-4 py-2.5` → `px-2.5 py-2 rounded-[7px]`. Ver [UPGRADE.md](UPGRADE.md#v4-dropdown-item)
- **[BREAKING] Pagination (JETAX-044):** botões de página `w-8 h-8 rounded-lg` → `min-w-[38px] h-[38px] rounded-[9px]`, com borda `border-outline-variant` fora da página atual. Ver [UPGRADE.md](UPGRADE.md#v4-pagination)
- **[BREAKING] Sidebar e largura da topbar (JETAX-045):** sidebar `w-64` → `w-[246px]` com `border-r` no lugar da sombra lateral, textos por token de tema; o default de `sidebar-width` da topbar passa de `16rem` a `246px`. Ver [UPGRADE.md](UPGRADE.md#v4-sidebar)
- **[BREAKING] Toggle (JETAX-046):** trilho `rounded-full` → `rounded-[999px]`. Ver [UPGRADE.md](UPGRADE.md#v4-toggle)
- **[BREAKING] Topbar (JETAX-047):** padding horizontal `md:px-5` → `md:px-[22px]`. Ver [UPGRADE.md](UPGRADE.md#v4-topbar)
- **Raiz única de `class`:** os 67 componentes de template aplicam o `class` do consumidor num único elemento raiz, sem repetir o atributo em outro elemento. Antes, 16 deles descartavam o `class` ou o mandavam para um elemento interno
- **Paleta nomeada trocada por token:** offcanvas (`bg-surface-container-lowest`), rating (`text-outline-variant`), toast-container (fundos sólidos do botão), tooltip (`bg-inverse-surface text-surface`) e upload deixam de usar literais `slate`/`gray`/`red`/`emerald`/`white`

### Fixed
- **JETAX-029:** os tamanhos `sm`, `md` e `lg` do botão com texto tinham altura por padding vertical, raio e borda do `outline` fora do mockup
- **JETAX-030:** o botão só de ícone não tinha o quadrado de 40 px da altura de campo nem o de 34 px, e o glifo `md` ficava 1 px menor que o do mockup
- **JETAX-031:** `Modal::SIZES` não tinha as larguras dos modais do mockup, e o painel tinha raio e sombra diferentes
- **JETAX-032:** o dialog tinha largura, raio, borda e sombra fora do mockup
- **JETAX-033:** o card tinha raio de 8 px, borda só no tema escuro, sombra no claro e nenhum estado de erro
- **JETAX-034:** a moldura da tabela tinha raio de 16 px, sombra inline e nenhuma borda, e o padding das células era outro
- **JETAX-035:** o badge não dispensava `uppercase`/`tracking-wider` e tinha raio, padding e borda fora do mockup
- **JETAX-036:** o select tinha raio, altura, padding e cor de borda fora do mockup e nenhum estado de erro fora do `$errors`
- **JETAX-037:** o input tinha raio de 4 px e padding horizontal de 16 px
- **JETAX-038:** o textarea tinha raio de 4 px e padding de `16px 12px`
- **JETAX-039:** o empty-state tinha padding de 48 px e nenhuma variante de uma linha nem moldura tracejada
- **JETAX-040:** a caixa do checkbox tinha 16 px no lugar de 15 px
- **JETAX-041:** o chip removível tinha padding esquerdo de 12 px no lugar de 11 px
- **JETAX-042:** o menu do dropdown tinha contorno por `ring`, sombra, raio e padding fora do mockup
- **JETAX-043:** o item do dropdown tinha padding fora do mockup e nenhum raio
- **JETAX-044:** o botão de página da paginação tinha 32 px, raio de 4 px e nenhuma borda
- **JETAX-045:** a sidebar tinha 256 px de largura e sombra lateral no lugar da borda, e a topbar assumia a mesma largura
- **JETAX-046:** o trilho do toggle tinha raio de 12 px (`rounded-full` do `@theme`) no lugar de pílula
- **JETAX-047:** a topbar tinha padding horizontal de 20 px no lugar de 22 px

### Added
- **`Modal::SIZES`:** chaves `md-lg` (600 px), `xl` (820 px), `2xl` (1080 px) e `3xl` (980 px), além de `sm`, `md`, `lg` e `fullscreen`
- **Botão `size="field"`:** `Button::SIZES['field']` (40 px, a altura do campo, com texto ou `icon-only`) e `Button::GLYPH_SIZES['field']` (`text-[14px]`)
- **`Button::ICON_ONLY_GLYPH_SIZES`:** glifo do botão só de ícone por `size` (`sm` 14, `md` 15, `field` 14, `lg` 18 px); sem `icon-only` vale `GLYPH_SIZES`
- **Prop `text-case` do badge:** `Badge::TEXT_CASES = ['upper', 'normal']`, default `upper`; `text-case="normal"` tira `uppercase` e `tracking-wider`
- **Prop `state` do select:** `Select::STATES = ['error']`, mesmo nome e valor do `state` do input; `state="error"` pinta a borda de erro sem depender do `$errors`
- **Prop `state` do card:** `Card::STATES = ['error']`; `state="error"` troca a borda por `border-error/34`
- **Prop `size` do empty-state:** `EmptyState::SIZES = ['md', 'sm']`, default `md`; `sm` é o vazio de uma linha
- **Prop `bordered` do empty-state:** moldura tracejada `border-primary/18` com raio 10 px
- **Prop `flush` da table:** tabela sem moldura, para uso direto dentro de um card
- Toda prop nova de valor enumerado segue a regra de variante inválida (exceção em `local`/`testing`, fallback com `Log::warning` nos demais)

## [3.0.0] - 2026-10-09

Versão major: troca o sistema de ícones do Material Symbols para a webfont do Font Awesome
Free 6.7.2. O pacote passa a emitir só a marcação; quem importa a folha é a aplicação, dentro
de uma cascade layer. Os itens marcados com **[BREAKING]** quebram a API da 2.x; o passo a passo
de cada um está no guia de migração [`UPGRADE.md`](UPGRADE.md).

### Changed
- **[BREAKING] Sistema de ícones (JETAX-017):** `<x-jetax-icon>` e todos os componentes que exibem ícone emitem `<i class="fa-<estilo> fa-<nome>" aria-hidden="true"></i>` no lugar do `<span class="material-symbols-outlined">` com ligadura. Ver [UPGRADE.md](UPGRADE.md#v3-marcacao)
- **[BREAKING] Prop `icon` e `name` em nome do Font Awesome:** a prop `icon` de button, alert, input, dropdown-item, page-header, empty-state, timeline-item, stats-card, list-group-item, activity-feed-item, `ActionsColumn`, `BulkAction::icon()` e `navigation` do config recebe `[estilo:]<nome FA canônico>`; os nomes do Material deixam de valer. Ver [UPGRADE.md](UPGRADE.md#v3-icon-estilo)
- **[BREAKING] Import do Font Awesome pelo consumidor:** a aplicação instala `@fortawesome/fontawesome-free` pelo npm e importa a folha no CSS de entrada, em `layer(base)`, antes de `@import "tailwindcss"`, sem CDN nem kit. Ver [UPGRADE.md](UPGRADE.md#v3-import-css)
- **[BREAKING] Tamanhos recalibrados:** os `size` nomeados de `<x-jetax-icon>` viram classes (`sm` → `text-[12px]`, `md` → `text-[15px]`, `lg` → `text-[18px]`, `xl` → `text-[24px]`), o `size` numérico é dividido por 1,35, e o `toast-container` troca o ícone por binding de classe no lugar de `x-text`. Ver [UPGRADE.md](UPGRADE.md#v3-tamanhos)

### Fixed
- **JETAX-017:** a folha de ícones entrava sem cascade layer e a regra de `font-size` dela vencia as utilitárias do Tailwind no call site. O pacote não carrega mais folha de ícone, e o import documentado do Font Awesome entra em `layer(base)`, então `text-[<n>px]` volta a valer
- **JETAX-014(c):** o glifo de `<x-jetax-button>` acompanha o `size` do botão, com e sem `icon-only` e nos dois lados: `sm` → `text-[12px]`, `md` → `text-[14px]`, `lg` → `text-[18px]`

### Removed
- **[BREAKING] Props `weight` e `fill` de `<x-jetax-icon>`:** o Font Awesome não tem eixo variável, e o componente não emite mais `font-variation-settings`. O preenchimento vem do estilo (`solid` ou `regular`). Ver [UPGRADE.md](UPGRADE.md#v3-weight-fill)
- **Folha do Material Symbols:** o `<link>` do Google Fonts saiu de `partials/fonts.blade.php`, e o pacote não referencia mais o Material em `resources`, `src`, `config` nem no `README.md`

### Added
- **Prop `variant` de `<x-jetax-icon>`:** `solid` (padrão), `regular` ou `brands`. Valor fora da lista, ou divergente do prefixo do `name`, segue a regra de variante inválida (exceção em `local`/`testing`, `solid` com `Log::warning` nos demais). Ver [UPGRADE.md](UPGRADE.md#v3-variant)
- **Prefixo `estilo:`:** `regular:bell` e `brands:whatsapp` escolhem o estilo do ícone na prop `icon` dos componentes, no `name` de `<x-jetax-icon>`, nos arrays `'icon' =>` e no config; sem prefixo vale `solid`
- **Manifesto do Font Awesome Free:** `resources/icons/fontawesome-free.json`, congelado na versão 6.7.2, com os nomes canônicos (sem aliases) de `solid`, `regular` e `brands`. Regenerado por `bin/generate-fontawesome-manifest.php` só junto com a troca da versão
- **`Support\FontAwesome`:** `parse()` resolve `[estilo:]nome` e `variant`, `has()` confere um nome no manifesto e `manifest()` devolve o manifesto lido
- **Guarda do sistema de ícones:** `IconFontAwesomeGuardTest` substitui o `IconSystemGuardTest` da 2.0 e reprova resquício de Material ou nome fora do manifesto

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
