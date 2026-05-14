# Changelog

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/),
e este projeto adere ao [Versionamento Semântico](https://semver.org/lang/pt-BR/).

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
