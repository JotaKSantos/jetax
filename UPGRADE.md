# Guia de migração 1.x → 2.0

A 2.0.0 alinha o Jetax à paleta e aos mockups do VetSoft e traz para o pacote a API que as
aplicações só tinham em views publicadas. Este guia lista cada quebra de API da
[seção 2.0.0 do CHANGELOG](CHANGELOG.md), com o uso antigo, o novo e o passo de migração.

## Checklist

- [ ] Trocar `jksantos/jetax` para `^2.0` no `composer.json` e rodar `composer update jksantos/jetax`.
- [ ] Remover a busca da topbar e mover o campo para o slot `leftActions` ou para a tela.
- [ ] Trocar `<x-jetax-tag>` por `<x-jetax-tag-input>`.
- [ ] Corrigir os valores inválidos de `variant`, `color` e `position` (agora lançam exceção em `local`/`testing`).
- [ ] Conferir layouts que dependiam da altura de 44px dos campos.
- [ ] Remover do CSS da aplicação as redefinições de `--color-*` que só existiam para corrigir a paleta antiga.
- [ ] Remover chamadas a `Dropdown::menuPositionClasses()`.
- [ ] Remover regras CSS que desligavam animações e usar `jetax.animations`.
- [ ] Remover `colors` e `primary_color` do `config/jetax.php` publicado.
- [ ] Apagar as views publicadas em `resources/views/vendor/jetax/` que só existiam para obter a API nova, e rodar `php artisan jetax:check` nas que ficarem.

## Quebras de API

<a id="quebra-topbar-sem-busca"></a>
### Topbar sem campo de busca

O campo "Pesquisar..." embutido saiu da `<x-jetax-topbar>` (JETAX-012). A barra usa a superfície
`bg-sidebar` nos dois temas, com borda inferior sempre presente, e ganhou o slot `leftActions`
e as props `sidebar-width` e `collapsed-width`.

**Antes**

```blade
<x-jetax-topbar title="Clientes">
    {{-- a busca vinha embutida, sem como trocar --}}
    <x-slot:actions>…</x-slot:actions>
</x-jetax-topbar>
```

**Depois**

```blade
<x-jetax-topbar title="Clientes" sidebar-width="246px" collapsed-width="70px">
    <x-slot:leftActions>
        <x-jetax-input name="q" placeholder="Pesquisar..." />
    </x-slot:leftActions>
    <x-slot:actions>…</x-slot:actions>
</x-jetax-topbar>
```

**Como migrar**

1. Se a aplicação usava a busca da topbar, coloque o campo no slot `leftActions` ou na própria tela.
2. Se a sidebar tem largura diferente de `16rem`/`70px`, passe `sidebar-width` e `collapsed-width`.
   As classes `md:left-[<valor>]` são arbitrárias: inclua-as no build do Tailwind da aplicação
   (ex.: `@source inline("md:left-[246px] md:left-[70px]")`).
3. Remova do CSS da aplicação as regras que reancoravam o fundo da topbar no tema escuro.

<a id="quebra-tag-input"></a>
### `x-jetax-tag` renomeado para `x-jetax-tag-input`

O campo de entrada de tags passou a se chamar `<x-jetax-tag-input>` (JETAX-021). O nome `tag`
deixa de existir, e a classe `Jetax\DesignSystem\View\Components\Tag` foi removida. O
`<x-jetax-chip>`, novo, é o selo de exibição sem estado.

**Antes**

```blade
<x-jetax-tag name="tags" :suggestions="$sugestoes" :max="5" />
```

**Depois**

```blade
<x-jetax-tag-input name="tags" :suggestions="$sugestoes" :max="5" />

{{-- só exibição, com remoção opcional --}}
<x-jetax-chip label="Situação: Quitado" removable wire:click="limparFiltro('situacao')" />
```

**Como migrar**

1. Troque `<x-jetax-tag` por `<x-jetax-tag-input` e `</x-jetax-tag>` por `</x-jetax-tag-input>`.
   A API (`suggestions`, `max`, `disabled`) é a mesma.
2. Troque referências à classe `Tag` por `TagInput`.
3. Onde a aplicação montava um selo removível à mão, use `<x-jetax-chip removable>`: os atributos
   passados ao chip (ex.: `wire:click`) vão para o `<button>` do `×`.

<a id="quebra-validacao-de-variante"></a>
### Validação de variante, cor e posição

`Badge::VARIANTS`, `Alert::VARIANTS`, `Button::COLORS` e `Dropdown::POSITIONS` passaram a ser
validados (JETAX-010). Um valor fora da lista lança `InvalidArgumentException` em `local` e
`testing`; nos demais ambientes o componente registra `Log::warning` e usa o padrão (`neutral`,
`primary`, `primary` e `bottom-start`). No `badge`, `color` é alias de `variant` e não aparece
mais como atributo HTML.

| Componente | Prop | Valores aceitos |
|---|---|---|
| `badge` | `variant` / `color` | `success`, `danger`, `warning`, `info`, `neutral` |
| `alert` | `variant` | `primary`, `info`, `success`, `warning`, `danger` |
| `button` | `color` | `primary`, `secondary`, `success`, `info`, `warning`, `danger`, `dark`, `light`, `custom` |
| `dropdown` | `position` | `bottom-start`, `bottom-end`, `top-start`, `top-end` |

**Antes**

```blade
{{-- aceito em silêncio: renderizava sem cor --}}
<x-jetax-badge variant="primary">Ativo</x-jetax-badge>
<x-jetax-badge color="danger">Vencido</x-jetax-badge> {{-- color ignorado e vazado no HTML --}}
```

**Depois**

```blade
<x-jetax-badge variant="info">Ativo</x-jetax-badge>
<x-jetax-badge color="danger">Vencido</x-jetax-badge> {{-- vale como variant="danger" --}}
```

**Como migrar**

1. Procure os call sites com valor fora da tabela (ex.: `variant="primary"`, `"secondary"` ou
   `"error"` no `badge`) e troque pelo valor equivalente.
2. Rode a suíte da aplicação em `testing`: a exceção aponta o componente, a prop e o valor.
3. Em produção, procure `valor "…" inválido` no log para achar call sites que a suíte não cobre.

<a id="quebra-altura-dos-campos"></a>
### Altura dos campos: 44px → 40px

`input` e `select` medem 40px pela classe `h-10` (JETAX-018), e não mais 44px por
`style="height: 44px;"`. A `class` passada ao componente chega ao elemento de campo, e o estado
de erro usa token em vez de `bg-red-50`.

**Antes**

```blade
{{-- altura inline de 44px; class ficava no wrapper --}}
<x-jetax-input name="cpf" class="font-mono" />
```

**Depois**

```blade
{{-- 40px por h-10; class chega ao <input> --}}
<x-jetax-input name="cpf" class="font-mono" />
```

**Como migrar**

1. Confira linhas de formulário que alinhavam campo e botão pela altura de 44px. O botão
   `icon-only` `md` mede 44px; use `size="sm"` ou ajuste o alinhamento (`items-end`, `items-center`).
2. Remova CSS da aplicação que forçava altura, cor de erro ou `class` no campo interno.
3. Classes que antes estilizavam o wrapper agora estilizam o `<input>`/`<select>`/`<textarea>`;
   mova para um elemento externo as que eram de layout.

<a id="quebra-tokens"></a>
### Tokens de cor trocados

Os valores de `--color-*` seguem a paleta VetSoft nos dois temas (JETAX-006, JETAX-008), com os
mesmos nomes no `@theme` (claro) e no `:root.dark` (escuro). Nenhum token foi renomeado nem
removido; entraram `success-text`, `primary-deep` e os tons sólidos `danger-solid`,
`success-solid`, `neutral-solid` e `warning-solid` (fundo para texto branco, contraste ≥ 4,5:1).

**Antes**

```css
/* app.css redefinia a paleta e reancorava literais do pacote */
@theme { --color-primary: #00548d; --color-surface: #eef3f7; }
:root.dark { --color-on-surface: #eef4f9; }
.dark .bg-red-50 { background: …; }
```

**Depois**

```css
@import "../../vendor/jksantos/jetax/resources/css/jetax.css";
/* sem redefinição: os valores já vêm do pacote */
```

**Como migrar**

1. Remova do CSS da aplicação as declarações `--color-*` que só replicavam a paleta VetSoft.
2. Remova regras que reancoravam classes literais do pacote (`.dark .bg-red-50`, seletores com
   `\[\#…\]`, `input:-webkit-autofill`, `select option`): o `jetax.css` já cobre esses casos.
3. Para uma paleta própria, sobrescreva os tokens depois do `@import`, nos dois temas
   (ver "Trocar a paleta por CSS" no README), sempre em pares de contraste.

<a id="quebra-dropdown-menu-position-classes"></a>
### `Dropdown::menuPositionClasses()` removido

O menu do `<x-jetax-dropdown>` deixou de ser `absolute` (JETAX-004). Ele é `fixed`, posicionado
pelo retângulo do gatilho, sem teleporte, e por isso não é recortado por ancestral com
`overflow-hidden`. `menuPositionClasses()` deu lugar a `vertical()` (`top`/`bottom`) e
`horizontal()` (`start`/`end`).

**Antes**

```blade
{{-- view publicada --}}
<div class="absolute {{ $menuPositionClasses() }} mt-2">…</div>
```

**Depois**

```blade
<x-jetax-dropdown position="top-end">
    <x-slot:trigger>…</x-slot:trigger>
    …
</x-jetax-dropdown>
```

**Como migrar**

1. Apague a view publicada do dropdown e use a do pacote.
2. Se código próprio chamava `menuPositionClasses()`, use `vertical()` e `horizontal()`.
3. Remova contornos para menu recortado (`overflow-visible` no card, `x-teleport` local).

<a id="quebra-animacoes"></a>
### Animações controladas por `jetax.animations`

As transições de `dialog`, `modal`, `dropdown` e `popover` passaram a depender da chave
`jetax.animations` (padrão `true`). Com `false`, esses componentes não emitem `x-transition`, os
layouts do pacote marcam o `<html>` com `data-jetax-animations="off"` e as classes
`jetax-animate-fade-*`/`jetax-animate-slide-*` deixam de animar. `shimmer` e `spin` continuam.

**Antes**

```css
/* app.css desligava as animações por CSS */
.jetax-animate-fade-in, .jetax-animate-slide-up { animation: none !important; }
[x-transition] { transition: none !important; }
```

**Depois**

```php
// config/jetax.php
'animations' => false,
```

**Como migrar**

1. Remova do CSS da aplicação as regras que anulavam `.jetax-animate-*` ou transições.
2. Para desligar, publique o config e defina `'animations' => false`.
3. Layouts próprios (sem `x-jetax-layout`) precisam marcar o `<html>` com
   `data-jetax-animations="off"` quando a chave estiver desligada.

<a id="quebra-jetax-colors"></a>
### Chave `colors` removida de `config/jetax.php`

As chaves `colors` e `primary_color` saíram do config (JETAX-011). Elas eram publicadas, mas
nenhum componente as lia: alterar um valor não mudava nada na tela.

**Antes**

```php
// config/jetax.php
'colors' => [
    'primary' => '#7c3aed',
],
```

**Depois**

```css
@import "../../vendor/jksantos/jetax/resources/css/jetax.css";

:root { --color-primary: #7c3aed; }
:root.dark { --color-primary: #a78bfa; }
```

**Como migrar**

1. Apague `colors` e `primary_color` do `config/jetax.php` publicado.
2. Leve cada cor customizada para o CSS da aplicação como `--color-<nome>`, nos dois temas.
3. Troque leituras de `config('jetax.colors…')` por `var(--color-<nome>)` no CSS.

## Contratos de componente da 2.0

Resumo da API pública que a 2.0.0 garante (CT-01..CT-17).

- **CT-01** `<x-jetax-toggle|currency wire:model[.<mod>]="prop">`: lê por `$wire.get(prop)` e grava por `$wire.$set(prop, valor, live)`, com `live` quando o modificador contém `live`. A saída não contém `wire:model`. Sem `wire:model`, o valor vai no POST por `<input type="hidden" name>`.
- **CT-02** `<x-jetax-dropdown position="bottom-start|bottom-end|top-start|top-end">`: slots `trigger` e default. Valor fora da lista segue a validação de variante.
- **CT-03** `<x-jetax-badge variant|color="success|danger|warning|info|neutral" style size square>`: `color` é alias de `variant`.
- **CT-04** `<x-jetax-page-header title subtitle breadcrumbs icon heading="h1|h2" subtitle-beside-icon>`: slots `titleAfter` e `actions`.
- **CT-05** `<x-jetax-button … icon-only color="<8 cores>|custom" color-token="<nome de token>">`.
- **CT-06** `<x-jetax-pagination :paginator livewire>`: no modo `livewire`, cada página é `wire:click="gotoPage(N, '<pageName>')"`.
- **CT-07** `<x-jetax-chip label removable>` + slot default: os atributos de remoção vão para o `<button>` do `×`. `<x-jetax-tag-input>` tem a API do antigo `tag`.
- **CT-08** `<x-jetax-button-group split>` com filhos `x-jetax-button`/`x-jetax-dropdown`.
- **CT-09** `<x-jetax-table :columns :rows :paginator>`: coluna `{key, label, sortable?, align?, width?, class?, thClass?, attributes?}`, slots `cell-<key>` e evento `sort` (`{key, direction}`).
- **CT-10** `<x-jetax-popover :open>`: evento `close`, slots default (gatilho) e `content`.
- **CT-11** `<x-jetax-stats-card label value icon tone="neutral|success|danger|warning|info" layout="figure" hint highlighted>`.
- **CT-12** `<x-jetax-modal id size level>`: attribute bag na raiz; eventos de janela `modal-open`/`modal-close`.
- **CT-13** `<x-jetax-editor wire:model|value readonly without-link data-editor-key>`: evento de janela `editor-insert` com `{editor, text}`, filtrado por `editor === data-editor-key`.
- **CT-14** `<x-jetax-timeline-item color icon>` + slot `marker-overlay` + âncora `data-jetax-timeline-marker-overlay`.
- **CT-15** `<x-jetax-dialog id … confirm-disabled panel-width="narrow">`: slots default (corpo livre) e `footer`; âncoras `data-dialog-cancel`/`data-dialog-confirm`; eventos `dialog-open`/`dialog-close`.
- **CT-16** `<x-jetax-topbar title sidebar-width collapsed-width>`: slots `leftActions` e `actions`.
- **CT-17** tokens CSS `--color-*`, com os mesmos nomes nos dois temas. Renomear ou remover um token é quebra de API e entra neste guia.

### Configuração `jetax.animations`

| Valor | Efeito |
|---|---|
| `true` (padrão) | `dialog`, `modal`, `dropdown` e `popover` abrem e fecham com `x-transition`; `jetax-animate-*` animam. |
| `false` | Sem `x-transition` nesses quatro componentes; `<html data-jetax-animations="off">` nos layouts do pacote; `fade`/`slide` param; `shimmer` e `spin` continuam. |
