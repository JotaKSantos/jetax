<a id="guia-3x-40"></a>
# Guia de migração 3.x → 4.0 (v3 → v4)

A 4.0.0 alinha a **forma** dos componentes (raio, altura, padding, largura, borda, sombra, glifo,
caixa e cor de borda de estado) aos mockups do VetSoft no Claude Design, pelas issues JETAX-029 a
JETAX-047. Nenhuma prop, slot, atributo `data-*` ou chave de `SIZES`/`STYLES`/`COLORS`/`GLYPH_SIZES`
foi removida, mas os defaults visuais abaixo mudaram: quem usa a 3.x sem prop explícita vê o
componente com outra medida. Este guia lista cada quebra da
[seção 4.0.0 do CHANGELOG](CHANGELOG.md), com o uso antigo, o novo e o passo de migração.

## Checklist da 4.0

- [ ] Trocar `jksantos/jetax` para `^4.0` no `composer.json` e rodar `composer update jksantos/jetax`.
- [ ] Procurar na aplicação compensações de forma em tags `<x-jetax-*>` (`!rounded-*`, `!h-*`, `!p-*`, `!max-w-*`, `[&_.fa-solid]:text-*`, `[&_th]:*`, `!normal-case`, `!border-error*`) e trocar cada uma pela prop nova ou removê-la quando o pacote já entrega a forma.
- [ ] Conferir o `size` de cada `<x-jetax-modal>`: `md` e `lg` mudaram de largura, e há quatro chaves novas.
- [ ] Conferir telas com botões `md`, `outline` ou só de ícone: alturas, raios, borda do `outline` e glifo `md` mudaram.
- [ ] Trocar `size` inválido de `<x-jetax-button>` e `<x-jetax-modal>` por um valor da constante: agora ele lança exceção em `local`/`testing`.
- [ ] Apagar ou atualizar as views publicadas em `resources/views/vendor/jetax/` dos componentes listados abaixo, para não congelar a forma da 3.x.

## Quebras de forma da 4.0

<a id="v4-botao-glifo"></a>
### Botão: glifo `md` 14 → 15 px

`Button::GLYPH_SIZES['md']` passa de `text-[14px]` a `text-[15px]` (JETAX-030), que é o glifo do
botão "Atualizar" do mockup (`Clientes.dc.html:152`). O só-ícone usa a constante nova
`Button::ICON_ONLY_GLYPH_SIZES`, também com `md` = 15 px. `sm` (12 px) e `lg` (18 px) não mudam.

**Antes**

```html
<!-- <x-jetax-button icon="rotate">Atualizar</x-jetax-button> -->
<i class="fa-solid fa-rotate text-[14px]" aria-hidden="true"></i>
```

**Depois**

```html
<i class="fa-solid fa-rotate text-[15px]" aria-hidden="true"></i>
```

**Como migrar**

1. Remova os seletores `[&_.fa-solid]:text-[15px]` dos botões `md`: o pacote já entrega 15 px.
2. Onde a tela precisa de 14 px ao lado de um campo, use `size="field"` (glifo de 14 px) no lugar
   de `[&_.fa-solid]:text-[14px]`.
3. Ajuste testes que afirmavam `text-[14px]` no glifo do botão `md`.

<a id="v4-botao-tamanhos"></a>
### Botão: tamanhos, raio e borda do `outline`

Os tamanhos passam a ter altura fixa no lugar de padding vertical (JETAX-029, JETAX-030), e a borda
do `outline` fica com 1 px. `Button::SIZES` ganha `field` (40 px, a altura do campo). O `size`
passa a ser validado: valor fora de `Button::SIZES` lança exceção em `local`/`testing` e cai em
`md` com `Log::warning` nos demais ambientes.

**Antes**

| tamanho | com texto | só ícone |
|---|---|---|
| `sm` | `px-3 py-1.5 text-xs rounded-lg` | `w-8 h-8 rounded-lg` |
| `md` | `px-5 py-2.5 text-sm rounded-xl` | `w-11 h-11 rounded-xl` |
| `lg` | `px-8 py-4 text-lg rounded-xl` | `w-12 h-12 rounded-xl` |
| `outline` | `border-2` | `border-2` |

**Depois**

| tamanho | com texto | só ícone |
|---|---|---|
| `sm` | `h-[34px] px-3 text-xs rounded-[8px]` | `w-[34px] h-[34px] rounded-[8px]` |
| `md` | `h-11 px-5 text-sm rounded-xl` (`outline`: `h-10 px-[18px]`) | `w-11 h-11 rounded-[10px]` |
| `lg` | `h-[52px] px-8 text-lg rounded-[10px]` | `w-12 h-12 rounded-xl` |
| `field` (novo) | `h-10 px-[18px] text-sm rounded-[8px]` | `w-10 h-10 rounded-[8px]` |
| `outline` | `border` | `border` |

**Como migrar**

1. Troque `!h-10 !w-10 !p-0` em botão só de ícone ao lado de campo por `icon-only size="field"`.
2. Troque `!w-[34px] !h-[34px] !p-0` por `icon-only size="sm"`.
3. Remova `!rounded-*`, `!h-*` e `!border` que só reproduziam a forma do mockup.
4. Corrija todo `size` fora de `sm`, `md`, `lg` e `field`.

<a id="v4-modal"></a>
### Modal: recalibração de `Modal::SIZES`

`Modal::SIZES` passa de `['sm', 'md', 'lg', 'fullscreen']` a
`['sm', 'md', 'md-lg', 'lg', 'xl', '2xl', '3xl', 'fullscreen']` (JETAX-031). `md` e `lg` mudam
de largura, as quatro chaves novas vêm dos modais do mockup, e o painel ganha o raio e a sombra do
mockup (`Clientes.dc.html:1005`). O `size` passa a ser validado: valor fora da lista lança
exceção em `local`/`testing` e cai em `md` com `Log::warning` nos demais. Não existe prop de
largura livre. O nome `3xl` (980 px) é mais estreito que `2xl` (1080 px).

**Antes**

| chave | classe | px |
|---|---|---|
| `sm` | `max-w-xs` | 320 |
| `md` | `max-w-xl` | 576 |
| `lg` | `max-w-4xl` | 896 |
| `fullscreen` | `w-full max-w-full h-full` | — |
| painel | `rounded-xl shadow-2xl` | — |

**Depois**

| chave | classe | px |
|---|---|---|
| `sm` | `max-w-xs` | 320 |
| `md` | `max-w-[560px]` | 560 |
| `md-lg` (novo) | `max-w-[600px]` | 600 |
| `lg` | `max-w-[660px]` | 660 |
| `xl` (novo) | `max-w-[820px]` | 820 |
| `2xl` (novo) | `max-w-[1080px]` | 1080 |
| `3xl` (novo) | `max-w-[980px]` | 980 |
| `fullscreen` | `w-full max-w-full h-full` | — |
| painel | `rounded-[14px] shadow-[0_24px_60px_rgb(9_42_66/0.16)]` | — |

**Como migrar**

1. Troque cada `!max-w-*` do modal pelo `size` de largura mais próxima (ex.: `!max-w-2xl`,
   672 px → `size="lg"`, 660 px; `!max-w-5xl`, 1024 px → `size="3xl"`, 980 px).
2. Revise os modais com `size="lg"` sem compensação: eles encolhem de 896 px para 660 px. Se a
   tela precisar da largura antiga, use `size="xl"` (820 px) ou `size="2xl"` (1080 px).
3. Corrija todo `size` fora da lista.

<a id="v4-dialog"></a>
### Dialog: largura, raio, borda e sombra

O painel de confirmação com corpo livre fica 12 px mais largo, e os três painéis do dialog ganham
o raio, a borda e a sombra do modal (JETAX-032, `Clientes.dc.html:1145`).

**Antes**

```text
max-w-md (448 px) · rounded-xl shadow-2xl · sem borda
```

**Depois**

```text
max-w-[460px] · rounded-[14px] border border-outline-variant shadow-[0_24px_60px_rgb(9_42_66/0.16)]
```

**Como migrar**

1. Remova compensações de raio, borda e sombra no `<x-jetax-dialog>`.
2. Confira telas que dependiam da largura de 448 px.

<a id="v4-card"></a>
### Card: raio, borda e sombra

O card tem raio de 10 px, borda `border-outline-variant` nos dois temas e não tem mais sombra no
tema claro (JETAX-033). O estado de erro vem da prop nova `state="error"`.

**Antes**

```text
rounded-xl · shadow-sm shadow-on-surface/5 · borda só em dark:border
```

**Depois**

```text
rounded-[10px] · border border-outline-variant · sem sombra no claro · state="error" → border-error/34
```

**Como migrar**

1. Troque `!border !border-error/60` por `state="error"`.
2. Remova `!rounded-[10px]` e as compensações de borda que só reproduziam o mockup.
3. Se a tela precisa da sombra antiga, aplique-a no call site como layout da tela.

<a id="v4-table"></a>
### Table: moldura e padding das células

O contêiner da tabela ganha borda e raio de 14 px e perde a sombra inline; `th` e `td` passam a
`px-4 py-3.5` (JETAX-034). A prop nova `flush` tira a moldura, para a tabela dentro de um card.

**Antes**

```text
contêiner: rounded-2xl · style="box-shadow: 0 4px 20px -2px …" · sem borda
th: px-6 py-3 · td: px-6 py-2.5
```

**Depois**

```text
contêiner: rounded-[14px] border border-outline-variant · sem sombra
th: px-4 py-3.5 · td: px-4 py-3.5
flush: rounded-none, sem borda e sem sombra
```

**Como migrar**

1. Remova `[&_th]:*` e `[&_td]:*` que só reproduziam o padding do mockup.
2. Use `flush` na tabela colada dentro de um `<x-jetax-card>`.
3. Ajuste testes que afirmavam `px-6` nas células.

<a id="v4-badge"></a>
### Badge: raio, padding, borda e caixa

O badge não quadrado tem raio de 6 px, o `md` fica mais baixo e o estilo `status` perde a borda
(JETAX-035). A prop nova `text-case="normal"` tira `uppercase` e `tracking-wider`.

**Antes**

```text
rounded-full · md: px-3 py-1 · status: border border-* · sempre uppercase tracking-wider
```

**Depois**

```text
rounded-[6px] · md: px-2 py-0.5 leading-[15px] · status: sem borda · text-case="upper" (default) | "normal"
```

**Como migrar**

1. Troque `!normal-case !tracking-normal` por `text-case="normal"`.
2. Remova compensações de raio e padding do badge.
3. Ajuste testes que afirmavam `border` no badge de `status`.

<a id="v4-select"></a>
### Select: altura, raio, padding e borda

O select tem 38 px de altura, raio de 8 px, `pl-2.5` e borda padrão `border-primary/18`
(JETAX-036). A prop nova `state="error"`, com o mesmo nome e valor do `<x-jetax-input>`, pinta a
borda de erro sem depender do `$errors`.

**Antes**

```text
h-10 rounded-lg pl-4 pr-9 · border-outline-variant
```

**Depois**

```text
h-[38px] rounded-[8px] pl-2.5 pr-9 · border-primary/18 · state="error" → border-error
```

**Como migrar**

1. Troque `!border-error` por `state="error"`.
2. Confira formulários que alinhavam o select a um input de 40 px pela altura.

<a id="v4-input"></a>
### Input: raio e padding

O input tem raio de 8 px e padding horizontal de 12 px em todos os estados (JETAX-037). A altura
de 40 px não muda.

**Antes**

```text
h-10 rounded-lg px-4
```

**Depois**

```text
h-10 rounded-[8px] px-3
```

**Como migrar**

1. Remova `!rounded-*` e `!px-*` que reproduziam o mockup.
2. Ajuste testes que afirmavam `rounded-lg px-4`.

<a id="v4-textarea"></a>
### Textarea: raio e padding

O textarea tem raio de 8 px e padding de 10 px (JETAX-038).

**Antes**

```text
rounded-lg px-4 py-3
```

**Depois**

```text
rounded-[8px] p-2.5
```

**Como migrar**

1. Remova compensações de raio e padding do `<x-jetax-textarea>`.

<a id="v4-empty-state"></a>
### Empty state: padding, tamanho e moldura

O padding padrão passa de 48 px a `40px 20px` (JETAX-039). As props novas `size="sm"` (vazio de
uma linha, peso 700) e `bordered` (moldura tracejada com raio 10 px) cobrem as variações do
mockup.

**Antes**

```text
p-12 · descrição: text-on-surface-variant text-sm mb-8 max-w-xs
```

**Depois**

```text
px-5 py-10 · size="md" (default) | "sm": text-sm font-bold text-on-surface · bordered: border-dashed border-primary/18 rounded-[10px]
```

**Como migrar**

1. Troque o seletor `[&_p]:!…` da descrição por `size="sm"`.
2. Troque a moldura tracejada escrita no call site por `bordered`.

<a id="v4-checkbox"></a>
### Checkbox: tamanho da caixa

A caixa do checkbox tem 15 px no lugar de 16 px (JETAX-040). Raio e borda não mudam.

**Antes**

```text
w-4 h-4
```

**Depois**

```text
w-[15px] h-[15px]
```

**Como migrar**

1. Remova `!w-*`/`!h-*` que reproduziam os 15 px.

<a id="v4-chip"></a>
### Chip: padding do chip removível

O chip removível tem padding esquerdo de 11 px (JETAX-041). A altura `h-7` não muda.

**Antes**

```text
pl-3
```

**Depois**

```text
pl-[11px]
```

**Como migrar**

1. Remova `!pl-*` do `<x-jetax-chip removable>`.

<a id="v4-dropdown"></a>
### Dropdown: moldura e sombra do menu

O menu troca o `ring-1` por borda, ganha a sombra do mockup, raio de 10 px e `p-1.5` (JETAX-042).

**Antes**

```text
rounded-xl architect-shadow ring-1 ring-outline-variant py-2
```

**Depois**

```text
rounded-[10px] border border-outline-variant shadow-[0_12px_30px_rgb(9_42_66/0.16)] p-1.5
```

**Como migrar**

1. Remova compensações de raio, sombra e contorno do menu.
2. Confira itens largos: o padding lateral do menu passou a 6 px.

<a id="v4-dropdown-item"></a>
### Dropdown item: padding e raio

O item tem `px-2.5 py-2` e raio de 7 px, no link e no botão (JETAX-043).

**Antes**

```text
px-4 py-2.5 · sem raio
```

**Depois**

```text
px-2.5 py-2 rounded-[7px]
```

**Como migrar**

1. Remova `!px-*`, `!py-*` e `!rounded-*` do `<x-jetax-dropdown-item>`.

<a id="v4-pagination"></a>
### Pagination: altura, borda e raio dos botões

Os botões de página e as setas têm 38 px, raio de 9 px e borda `border-outline-variant`; a página
atual não tem borda (JETAX-044).

**Antes**

```text
w-8 h-8 rounded-lg · sem borda
```

**Depois**

```text
min-w-[38px] h-[38px] rounded-[9px] border border-outline-variant (página atual sem borda)
```

**Como migrar**

1. Remova compensações de tamanho e raio da paginação.
2. Confira rodapés estreitos: cada botão ficou 6 px maior.

<a id="v4-sidebar"></a>
### Sidebar e topbar: largura de 246 px

A sidebar tem 246 px e `border-r` no lugar da sombra lateral, e os textos usam tokens de tema
(`on-surface`, `on-surface-variant`, `primary`) no lugar de `white`/`slate` (JETAX-045). O default
da prop `sidebar-width` da topbar acompanha a sidebar.

**Antes**

```text
sidebar: w-64 (256 px) · sombra lateral · text-white / text-slate-400
topbar: sidebar-width="16rem"
```

**Depois**

```text
sidebar: w-[246px] · border-r border-outline-variant · text-on-surface / text-on-surface-variant / text-primary
topbar: sidebar-width="246px"
```

**Como migrar**

1. Se o layout publicava a sidebar com outra largura, passe a mesma largura em `sidebar-width`.
2. Remova `!w-*` e sombras escritas para imitar o mockup.

<a id="v4-toggle"></a>
### Toggle: raio do trilho

O trilho do toggle é uma pílula de verdade (JETAX-046). O `rounded-full` do `@theme` do pacote vale
12 px; o trilho passa a `rounded-[999px]`. A largura `w-11` não muda.

**Antes**

```text
rounded-full (12 px no @theme)
```

**Depois**

```text
rounded-[999px]
```

**Como migrar**

1. Remova `!rounded-*` do trilho do `<x-jetax-toggle>`.

<a id="v4-topbar"></a>
### Topbar: padding horizontal

A topbar tem padding horizontal de 22 px a partir de `md` (JETAX-047).

**Antes**

```text
md:px-5
```

**Depois**

```text
md:px-[22px]
```

**Como migrar**

1. Remova `!px-*` da topbar.

## Referência da 4.0

### Chaves públicas

Nenhuma chave existente de `SIZES`, `STYLES`, `COLORS` ou `GLYPH_SIZES` foi removida. Chaves e
props novas: `Modal::SIZES` `md-lg`, `xl`, `2xl`, `3xl`; `Button::SIZES['field']`,
`Button::GLYPH_SIZES['field']`, `Button::ICON_ONLY_GLYPH_SIZES`; `Badge::TEXT_CASES` e a prop
`text-case`; `Select::STATES` e `Card::STATES` com a prop `state`; `EmptyState::SIZES` e as props
`size` e `bordered`; a prop `flush` da table. Toda prop nova de valor enumerado segue a regra de
variante inválida.

### Glifo do botão

O glifo do `<x-jetax-button>` continua com valores fixos que acompanham a fonte do botão: 12, 15 e
18 px em `sm`, `md` e `lg`, e 14 px em `field`. No só-ícone, `sm` sobe para 14 px.

---

<a id="guia-2x-30"></a>
# Guia de migração 2.x → 3.0

A 3.0.0 troca o sistema de ícones do Material Symbols para a webfont do **Font Awesome Free
6.7.2**. O pacote passa a emitir só a marcação (`<i class="fa-<estilo> fa-<nome>">`) e não
carrega folha de ícone nenhuma: quem importa o Font Awesome é a aplicação. Este guia lista cada
quebra da [seção 3.0.0 do CHANGELOG](CHANGELOG.md), com o uso antigo, o novo e o passo de
migração.

## Checklist da 3.0

- [ ] Trocar `jksantos/jetax` para `^3.0` no `composer.json` e rodar `composer update jksantos/jetax`.
- [ ] Instalar `@fortawesome/fontawesome-free@6.7.2` pelo npm e importar a folha no CSS de entrada, em `layer(base)`.
- [ ] Remover o import do Material Symbols do CSS e dos layouts da aplicação.
- [ ] Trocar todo nome de ícone do Material pelo nome canônico do Font Awesome, com `regular:` ou `brands:` quando o estilo não for `solid`.
- [ ] Remover `weight` e `fill` de `<x-jetax-icon>` e escolher o estilo por `variant` ou prefixo.
- [ ] Recalibrar as classes de tamanho dos ícones da aplicação pela regra ÷ 1,35.
- [ ] Trocar `x-text`/`x-html` em elemento de ícone por binding de classe.
- [ ] Apagar as views publicadas em `resources/views/vendor/jetax/` que ainda emitem `material-symbols-outlined`, e rodar `php artisan jetax:check` nas que ficarem.

## Quebras de API da 3.0

<a id="v3-marcacao"></a>
### Marcação do ícone: `span` com ligadura → `i` com classes FA

`<x-jetax-icon>` e todos os componentes que exibem ícone deixam de emitir um `<span>` com a
classe `material-symbols-outlined` e o nome do ícone como texto (ligadura). A saída passa a ser
um `<i>` vazio com as classes do Font Awesome e `aria-hidden="true"` (JETAX-017).

**Antes**

```html
<span class="material-symbols-outlined" style="font-size: 20px; font-variation-settings: 'FILL' 0, 'wght' 400; color: inherit;">pets</span>
```

**Depois**

```html
<i class="fa-solid fa-paw text-[15px]" aria-hidden="true"></i>
```

**Como migrar**

1. Troque na aplicação todo `<span class="material-symbols-outlined">nome</span>` escrito à mão
   por `<x-jetax-icon name="…" />` ou por `<i class="fa-solid fa-…" aria-hidden="true"></i>`.
2. Ajuste seletores CSS e de teste que procuravam `material-symbols-outlined` ou o texto do
   ícone: o elemento agora é `<i>` e não tem texto.
3. Ícone sem rótulo visível continua precisando de `aria-label` ou `title` no elemento
   interativo que o contém, porque o `<i>` é `aria-hidden`.

<a id="v3-weight-fill"></a>
### Props `weight` e `fill` removidas

O Font Awesome não tem eixo variável. `<x-jetax-icon>` não aceita mais `weight` nem `fill` e não
emite `font-variation-settings`. O "preenchido" e o "contorno" passam a ser estilos distintos.

**Antes**

```blade
<x-jetax-icon name="favorite" :fill="true" :weight="600" />
<x-jetax-icon name="favorite" />
```

**Depois**

```blade
<x-jetax-icon name="heart" />            {{-- preenchido: solid --}}
<x-jetax-icon name="regular:heart" />    {{-- contorno: regular --}}
```

**Como migrar**

1. Remova `weight` e `fill` de todo `<x-jetax-icon>`; passados como atributo, eles vazariam
   para o HTML.
2. Ícone com `fill` ligado vira o estilo `solid` (o padrão).
3. Ícone em contorno vira o estilo `regular`, quando o nome existe nele no manifesto. O Font
   Awesome Free tem bem menos nomes em `regular` que em `solid`; sem o nome em `regular`, use o
   `solid`.

<a id="v3-variant"></a>
### Prop `variant`

`<x-jetax-icon>` ganha a prop `variant`, com `solid` (padrão), `regular` ou `brands`. Ela escolhe
o estilo quando o `name` não tem prefixo.

**Antes**

```blade
{{-- não havia estilo: só o Material Symbols Outlined --}}
<x-jetax-icon name="notifications" />
```

**Depois**

```blade
<x-jetax-icon name="bell" variant="regular" />
<x-jetax-icon name="regular:bell" />                  {{-- equivalente --}}
<x-jetax-icon name="whatsapp" variant="brands" />
```

**Como migrar**

1. Use `variant` (ou o prefixo `estilo:`, ver a próxima seção) só quando o estilo não for `solid`.
2. Marcas (`whatsapp`, `instagram`, `pix`…) ficam em `brands` e não existem em `solid`.
3. Valor fora de `solid|regular|brands`, ou `variant` diferente do prefixo do `name`, segue a
   regra de variante inválida: `InvalidArgumentException` em `local`/`testing` e `solid` com
   `Log::warning` nos demais ambientes.

<a id="v3-icon-estilo"></a>
### `icon` dos componentes em `[estilo:]nome`

A prop `icon` de button, alert, input, dropdown-item, page-header, empty-state, timeline-item,
stats-card, list-group-item e activity-feed-item, o `icon` de `ActionsColumn` e de
`BulkAction::icon()`, os itens de `navigation` do config e o `name` de `<x-jetax-icon>` recebem
o nome canônico do Font Awesome, sem o `fa-`, com prefixo de estilo opcional. Sem prefixo, vale
`solid`. Não existe prop paralela de estilo nesses componentes.

**Antes**

```blade
<x-jetax-button icon="add">Novo</x-jetax-button>
<x-jetax-alert icon="notifications">Aviso</x-jetax-alert>
```

```php
// config/jetax.php
'navigation' => [
    ['label' => 'Clientes', 'icon' => 'group', 'route' => 'clientes.index'],
],
```

**Depois**

```blade
<x-jetax-button icon="plus">Novo</x-jetax-button>
<x-jetax-alert icon="regular:bell">Aviso</x-jetax-alert>
<x-jetax-button icon="brands:whatsapp">Enviar</x-jetax-button>
```

```php
// config/jetax.php
'navigation' => [
    ['label' => 'Clientes', 'icon' => 'users', 'route' => 'clientes.index'],
],
```

**Como migrar**

1. Troque cada nome do Material pelo nome canônico do Font Awesome (`add` → `plus`, `close` →
   `xmark`, `pets` → `paw`, `group` → `users`). Aliases do Font Awesome não valem: use o nome
   canônico.
2. Acrescente `regular:` ou `brands:` quando o estilo não for `solid`.
3. Faça o mesmo nos `icon()` de enums e presenters, nos arrays `'icon' =>` e no `navigation` do
   `config/jetax.php` publicado.
4. Confira os nomes no manifesto `resources/icons/fontawesome-free.json` do pacote, ou pela API
   `Jetax\DesignSystem\Support\FontAwesome::has($nome, $estilo)`.

<a id="v3-import-css"></a>
### Import do Font Awesome no CSS do consumidor, em layer e sem CDN

O pacote não carrega mais folha de ícone: o `<link>` do Google Fonts para o Material Symbols
saiu de `partials/fonts.blade.php`. A aplicação instala o Font Awesome pelo npm e importa a
folha no CSS de entrada do Vite, dentro de uma cascade layer declarada antes de `utilities`.
As webfonts saem do `node_modules` no build, sem CDN nem kit.

**Antes**

```css
/* resources/css/app.css */
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap');
@import "tailwindcss";
```

**Depois**

```bash
npm install --save-exact @fortawesome/fontawesome-free@6.7.2
```

```css
/* resources/css/app.css */
@import "@fortawesome/fontawesome-free/css/all.min.css" layer(base);
@import "tailwindcss";
```

**Como migrar**

1. Instale o Font Awesome Free em versão exata, a mesma do manifesto do pacote (6.7.2).
2. Remova o import do Material Symbols do CSS e qualquer `<link>` dele nos layouts.
3. Importe a folha com `layer(base)`, antes de `@import "tailwindcss"`. Fora de layer, a regra
   `font-size` da folha vence as utilitárias (`text-[18px]`) e o tamanho do call site deixa de
   valer (JETAX-017).
4. Não use CDN nem kit do Font Awesome.

<a id="v3-tamanhos"></a>
### Tamanhos recalibrados e `x-text` → binding de classe

O glifo do Font Awesome é maior que o do Material no mesmo `font-size`. Os tamanhos nomeados de
`<x-jetax-icon>` viram classes utilitárias, sem `style` inline, e o tamanho numérico é dividido
por 1,35. O glifo de `<x-jetax-button>` acompanha o `size` do botão (JETAX-014(c)). A troca de
ícone no cliente passa a ser por classe, porque o `<i>` do Font Awesome não tem texto.

| `size` | 2.x | 3.0 |
|--------|-----|-----|
| `sm` | `font-size: 16px` | `text-[12px]` |
| `md` (padrão) | `font-size: 20px` | `text-[15px]` |
| `lg` | `font-size: 24px` | `text-[18px]` |
| `xl` | `font-size: 32px` | `text-[24px]` |
| `<n>` | `font-size: <n>px` | `style="font-size:<m>px"`, `<m>` = `<n>` ÷ 1,35 arredondado |
| botão `sm`/`md`/`lg` | herdado | `text-[12px]` / `text-[14px]` / `text-[18px]` |

**Antes**

```blade
<x-jetax-icon name="pets" size="27" />
<span class="material-symbols-outlined text-[18px]">search</span>

<span class="material-symbols-outlined" x-text="open ? 'expand_less' : 'expand_more'"></span>
```

**Depois**

```blade
<x-jetax-icon name="paw" size="27" />   {{-- emite style="font-size:20px" --}}
<i class="fa-solid fa-magnifying-glass text-[13px]" aria-hidden="true"></i>

<i class="fa-solid" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" aria-hidden="true"></i>
```

**Como migrar**

1. Recalcule toda classe de tamanho de ícone escrita na aplicação pela regra de equivalência
   abaixo (ex.: `text-[18px]` → `text-[13px]`).
2. Não ajuste os `size` de `<x-jetax-icon>`: o componente já aplica a regra.
3. Troque `x-text`/`x-html` em elemento de ícone por `:class`/`x-bind:class` com os nomes FA;
   o `toast-container` do pacote já faz isso.

## Referência da 3.0

### Regra de equivalência de tamanho

O tamanho do Material equivale ao do Font Awesome × 1,35 (registrado na JETAX-017). Para
converter um tamanho da 2.x, divida o px por **1,35** e arredonde ao inteiro mais próximo:
16 → 12, 20 → 15, 24 → 18, 32 → 24. Para um utilitário nomeado do Tailwind (ex.: `text-base`),
parta do px da escala padrão do Tailwind v4. O glifo do `<x-jetax-button>` é a exceção, com
valores fixos que acompanham a fonte do botão (12, 14 e 18 px).

### Manifesto do Font Awesome Free

`resources/icons/fontawesome-free.json` traz os nomes canônicos (sem aliases) de `solid`,
`regular` e `brands`, ordenados, e a versão de origem (`"version": "6.7.2"`). Ele muda só junto
com a troca da versão do Font Awesome. Para regenerá-lo, a partir da raiz do Jetax:

```bash
VERSION=6.7.2
mkdir -p /tmp/fa && cd /tmp/fa
curl -sSfLo fa.tgz https://registry.npmjs.org/@fortawesome/fontawesome-free/-/fontawesome-free-$VERSION.tgz
tar xzf fa.tgz && cd -
docker run --rm -u "$(id -u):$(id -g)" \
  -v /tmp/fa/package:/fa:ro -v "$PWD":/app -w /app \
  laravelsail/php84-composer@sha256:a2716e93e577c80bca7551126056446c1e06cb141af652ee6932537158108400 \
  php bin/generate-fontawesome-manifest.php /fa/metadata
```

O script `bin/generate-fontawesome-manifest.php` recebe o diretório `metadata/` do pacote npm
extraído e, opcionalmente, o arquivo de saída.

---

<a id="guia-1x-20"></a>
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
