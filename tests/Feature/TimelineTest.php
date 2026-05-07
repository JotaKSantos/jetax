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
