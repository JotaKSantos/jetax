{{--
    Posicionamento flutuante compartilhado (dropdown, popover).

    Emite, para dentro de um `x-data`, as propriedades `vertical`, `horizontal` e `menuStyle`
    e o método `place()`. O painel fica `fixed` e é posicionado pelo `getBoundingClientRect()`
    do gatilho: elemento `fixed` tem o viewport como containing block, então o `overflow` de
    um ancestral (`overflow-hidden` do card, `overflow-x-auto` da tabela) não o recorta.

    Não usa `x-teleport`: o morph do Livewire deixa o elemento teleportado anterior órfão no
    `<body>`, e o resíduo aparece como um retângulo vazio sobre a tela.

    Quando o painel não cabe no lado pedido, vira para o outro, e só quando couber lá.

    Variáveis: `$vertical` (`top`|`bottom`), `$horizontal` (`start`|`center`|`end`), `$triggerRef`
    (padrão `trigger`) e `$panelRef` (padrão `menu`).
--}}
@php
    $triggerRef ??= 'trigger';
    $panelRef ??= 'menu';
@endphp
vertical: '{{ $vertical === 'top' ? 'top' : 'bottom' }}',
horizontal: '{{ in_array($horizontal, ['center', 'end'], true) ? $horizontal : 'start' }}',
menuStyle: 'top:-9999px;left:-9999px',

place() {
    const trigger = this.$refs.{{ $triggerRef }};
    const panel = this.$refs.{{ $panelRef }};

    if (! trigger || ! panel) {
        return;
    }

    const rect = trigger.getBoundingClientRect();
    const gap = 8;
    const height = panel.offsetHeight;
    const width = panel.offsetWidth;

    let top = this.vertical === 'top' ? rect.top - height - gap : rect.bottom + gap;

    if (this.vertical !== 'top' && top + height > window.innerHeight && rect.top - height - gap >= 0) {
        top = rect.top - height - gap;
    }

    if (this.vertical === 'top' && top < 0 && rect.bottom + gap + height <= window.innerHeight) {
        top = rect.bottom + gap;
    }

    let left = this.horizontal === 'end' ? rect.right - width : rect.left;

    if (this.horizontal === 'center') {
        left = rect.left + (rect.width - width) / 2;
    }

    left = Math.max(gap, Math.min(left, window.innerWidth - width - gap));

    this.menuStyle = `top:${Math.round(top)}px;left:${Math.round(left)}px`;
},
