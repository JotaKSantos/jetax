<?php

it('test_items_rendered', function () {
    $view = $this->blade(
        '<x-jetax-activity-feed>
            <x-jetax-activity-feed-item
                description="Cliente cadastrado no sistema"
                author="João Silva"
                timestamp="10:45"
                type="created"
            />
            <x-jetax-activity-feed-item
                description="Proposta atualizada"
                author="Maria Souza"
                timestamp="11:30"
                type="updated"
            />
        </x-jetax-activity-feed>'
    );

    $view->assertSee('Cliente cadastrado no sistema');
    $view->assertSee('Proposta atualizada');
    $view->assertSee('João Silva');
    $view->assertSee('Maria Souza');
    $view->assertSee('10:45');
    $view->assertSee('11:30');
});

it('test_date_grouping_rendered', function () {
    $view = $this->blade(
        '<x-jetax-activity-feed>
            <x-jetax-activity-feed-item
                description="Evento de hoje"
                date-label="Hoje"
                type="created"
            />
            <x-jetax-activity-feed-item
                description="Evento de ontem"
                date-label="Ontem"
                type="updated"
            />
        </x-jetax-activity-feed>'
    );

    $view->assertSee('Hoje');
    $view->assertSee('Ontem');
    $view->assertSee('Evento de hoje');
    $view->assertSee('Evento de ontem');
});

it('test_load_more_button_rendered', function () {
    $view = $this->blade(
        '<x-jetax-activity-feed :has-more="true">
            <x-jetax-activity-feed-item
                description="Atividade recente"
                type="created"
            />
        </x-jetax-activity-feed>'
    );

    $view->assertSee('Ver mais');
    $view->assertSee('load-more', false);
});
