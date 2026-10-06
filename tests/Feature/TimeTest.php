<?php

use Illuminate\Support\Facades\Blade;
use Jetax\DesignSystem\View\Components\Time;

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

    $view->assertSee('border-error', false);
    $view->assertDontSee('border-red-500', false);
});

it('test_consumer_class_reaches_time_input', function () {
    $html = Blade::render('<x-jetax-time name="horario" class="w-32" />');

    expect(tagClass(htmlTag($html, 'input')))->toContain('w-32')->toContain('h-10');
    expect($html)->not->toContain('style="height:');
});

it('test_label_uses_design_metric_and_token', function () {
    $html = Blade::render('<x-jetax-time name="horario" label="Horário" />');

    expect(tagClass(htmlTag($html, 'label')))
        ->toContain('text-[11px]')
        ->toContain('font-bold')
        ->toContain('tracking-[.06em]')
        ->toContain('text-on-surface-variant');
    expect($html)->toContain('id="time_horario"');
});

it('test_has_no_hex_color_utilities', function () {
    $html = Blade::render('<x-jetax-time name="horario" label="Horário" />');
    $time = new Time(name: 'horario');

    expect($html)->not->toContain('text-[#')->not->toContain('-[#');
    expect($time->inputClasses().$time->errorClasses())->not->toContain('#')->not->toContain('red-');
});
