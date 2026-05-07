<?php

it('test_title_and_description_rendered', function () {
    $view = $this->blade(
        '<x-jetax-empty-state title="Nenhum cliente encontrado" description="Comece adicionando um novo cliente." />'
    );

    $view->assertSee('Nenhum cliente encontrado');
    $view->assertSee('Comece adicionando um novo cliente.');
});

it('test_icon_rendered', function () {
    $view = $this->blade(
        '<x-jetax-empty-state title="Vazio" icon="person_search" />'
    );

    $view->assertSee('material-symbols-outlined', false);
    $view->assertSee('person_search');
});

it('test_cta_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-empty-state title="Vazio"><button>Criar Novo</button></x-jetax-empty-state>'
    );

    $view->assertSee('Criar Novo');
});
