<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Jetax\DesignSystem\View\Components\Alert;
use Jetax\DesignSystem\View\Components\Badge;
use Jetax\DesignSystem\View\Components\Button;

it('test_runs_in_testing_environment', function () {
    expect(config('app.env'))->toBe('testing');
});

it('test_valid_values_pass_through', function () {
    expect((new Badge(variant: 'success'))->variant)->toBe('success')
        ->and((new Alert(variant: 'warning'))->variant)->toBe('warning')
        ->and((new Button(color: 'dark'))->color)->toBe('dark');
});

it('test_invalid_value_throws_in_testing', function (string $component, string $prop, string $value) {
    expect(fn () => new $component(...[$prop => $value]))->toThrow(InvalidArgumentException::class, "\"{$value}\"");
})->with([
    'badge variant' => [Badge::class, 'variant', 'secondary'],
    'badge color' => [Badge::class, 'color', 'primary'],
    'alert variant' => [Alert::class, 'variant', 'error'],
    'button color' => [Button::class, 'color', 'tertiary'],
]);

it('test_invalid_value_throws_in_local', function () {
    config(['app.env' => 'local']);

    expect(fn () => new Badge(variant: 'secondary'))->toThrow(InvalidArgumentException::class, 'secondary');
});

it('test_exception_message_lists_accepted_values', function () {
    expect(fn () => new Button(color: 'tertiary'))
        ->toThrow(InvalidArgumentException::class, 'Button: valor "tertiary" inválido para "color". Valores aceitos: primary, secondary');
});

it('test_production_logs_warning_and_falls_back', function () {
    config(['app.env' => 'production']);
    Log::spy();

    expect((new Badge(variant: 'secondary'))->variant)->toBe('neutral')
        ->and((new Badge(color: 'error'))->variant)->toBe('neutral')
        ->and((new Alert(variant: 'error'))->variant)->toBe('primary')
        ->and((new Button(color: 'tertiary'))->color)->toBe('primary');

    Log::shouldHaveReceived('warning')->times(4);
    Log::shouldHaveReceived('warning')
        ->withArgs(fn (string $message, array $context): bool => str_contains($message, '"secondary"')
            && $context['fallback'] === 'neutral'
            && $context['prop'] === 'variant')
        ->once();
});

it('test_production_renders_fallback_instead_of_breaking_the_screen', function () {
    config(['app.env' => 'production']);
    Log::spy();

    $badge = Blade::render('<x-jetax-badge variant="secondary" style="status">Avisar</x-jetax-badge>');
    $button = Blade::render('<x-jetax-button color="tertiary">Salvar</x-jetax-button>');

    expect($badge)->toContain('text-on-surface-variant')->toContain('Avisar');
    expect($button)->toContain('bg-primary')->toContain('Salvar');

    Log::shouldHaveReceived('warning')->twice();
});
