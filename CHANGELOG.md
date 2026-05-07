# Changelog

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/),
e este projeto adere ao [Versionamento Semântico](https://semver.org/lang/pt-BR/).

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
