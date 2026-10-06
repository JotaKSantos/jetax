<?php

it('test_items_rendered', function () {
    $view = $this->blade(
        '<x-jetax-timeline>
            <x-jetax-timeline-item title="Cliente cadastrado" description="Novo registro de lead." date="10:30" />
            <x-jetax-timeline-item title="Invoice gerada" description="Fatura enviada." date="11:15" />
        </x-jetax-timeline>'
    );

    $view->assertSee('Cliente cadastrado');
    $view->assertSee('Invoice gerada');
    $view->assertSee('Novo registro de lead.');
    $view->assertSee('Fatura enviada.');
});

it('test_connector_line_present', function () {
    $view = $this->blade(
        '<x-jetax-timeline>
            <x-jetax-timeline-item title="Evento A" date="09:00" />
        </x-jetax-timeline>'
    );

    // O container da timeline vertical usa border-l para a linha conectora
    $view->assertSee('border-l', false);
});

it('test_horizontal_class_when_prop_provided', function () {
    $view = $this->blade(
        '<x-jetax-timeline :horizontal="true">
            <x-jetax-timeline-item title="Passo 1" date="Jan" />
            <x-jetax-timeline-item title="Passo 2" date="Fev" />
        </x-jetax-timeline>'
    );

    // Em modo horizontal, o container usa flex-row
    $view->assertSee('flex-row', false);
});

/**
 * Recorta a tag de abertura do medalhão do item.
 */
function timelineMarkerTag(string $html): string
{
    preg_match('/<div class="w-6 h-6 rounded-full[^"]*">/', $html, $match);

    return $match[0] ?? '';
}

it('test_marker_overlay_slot_in_vertical_branch', function () {
    $html = (string) $this->blade(
        '<x-jetax-timeline>
            <x-jetax-timeline-item title="Consulta" icon="stethoscope">
                <x-slot:marker-overlay><span data-selo>✓</span></x-slot:marker-overlay>
            </x-jetax-timeline-item>
        </x-jetax-timeline>'
    );

    expect(timelineMarkerTag($html))->toContain(' relative')
        ->and($html)->toMatch('/<span class="absolute -top-1\.5 -right-1\.5 [^"]*" data-jetax-timeline-marker-overlay><span data-selo>✓<\/span><\/span>/');
});

it('test_marker_overlay_slot_in_horizontal_branch', function () {
    $html = (string) $this->blade(
        '<x-jetax-timeline :horizontal="true">
            <x-jetax-timeline-item title="Passo 1">
                <x-slot name="marker-overlay"><span data-selo>✓</span></x-slot>
            </x-jetax-timeline-item>
        </x-jetax-timeline>'
    );

    expect($html)->toContain('min-w-[140px]')
        ->and(timelineMarkerTag($html))->toContain(' relative')
        ->and($html)->toContain('data-jetax-timeline-marker-overlay><span data-selo>');
});

it('test_without_marker_overlay_output_is_unchanged', function () {
    foreach (['false', 'true'] as $horizontal) {
        $html = (string) $this->blade(
            '<x-jetax-timeline :horizontal="'.$horizontal.'">
                <x-jetax-timeline-item title="Evento" icon="event" />
            </x-jetax-timeline>'
        );

        expect($html)->not->toContain('data-jetax-timeline-marker-overlay')
            ->and(timelineMarkerTag($html))->not->toBe('')
            ->and(timelineMarkerTag($html))->not->toContain('relative');
    }
});

it('test_blank_marker_overlay_is_ignored', function () {
    foreach (['false', 'true'] as $horizontal) {
        $html = (string) $this->blade(
            '<x-jetax-timeline :horizontal="'.$horizontal.'">
                <x-jetax-timeline-item title="Evento">
                    <x-slot:marker-overlay>   </x-slot:marker-overlay>
                </x-jetax-timeline-item>
            </x-jetax-timeline>'
        );

        expect($html)->not->toContain('data-jetax-timeline-marker-overlay')
            ->and(timelineMarkerTag($html))->not->toContain('relative');
    }
});
