<?php

it('test_renders_time_input', function () {
    $view = $this->blade('<x-jetax-time />');

    $view->assertSee('type="time"', false);
});

it('test_step_attribute_applied', function () {
    $view = $this->blade('<x-jetax-time :step="300" />');

    $view->assertSee('step="300"', false);
});

it('test_error_class_applied', function () {
    $view = $this->withViewErrors(['horario' => 'O campo horário é obrigatório'])
        ->blade('<x-jetax-time name="horario" />');

    $view->assertSee('border-red-500', false);
});
