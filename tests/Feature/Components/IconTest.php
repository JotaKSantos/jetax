<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Jetax\DesignSystem\View\Components\Icon;

/*
|--------------------------------------------------------------------------
| <x-jetax-icon> na webfont do Font Awesome (SPEC jetax-f2, RF-01, CT-01)
|--------------------------------------------------------------------------
*/

it('test_renders_font_awesome_solid_element_by_default', function () {
    $html = Blade::render('<x-jetax-icon name="paw" />');

    expect($html)
        ->toContain('fa-solid')
        ->toContain('fa-paw')
        ->toContain('aria-hidden="true"')
        ->not->toContain('material-symbols');

    expect(trim($html))->toStartWith('<i')->toEndWith('</i>');
    expect(trim(strip_tags($html)))->toBe('');
    expect(substr_count($html, '<i'))->toBe(1);
});

it('test_variant_emits_style_class', function (string $variant) {
    $html = Blade::render("<x-jetax-icon name=\"bell\" variant=\"{$variant}\" />");

    expect($html)->toContain("fa-{$variant} fa-bell");
})->with(['solid', 'regular', 'brands']);

it('test_name_prefix_emits_style_without_prefix_text', function (string $value, string $classes, string $prefix) {
    $html = Blade::render("<x-jetax-icon name=\"{$value}\" />");

    expect($html)
        ->toContain($classes)
        ->not->toContain($prefix);
})->with([
    ['regular:bell', 'fa-regular fa-bell', 'regular:'],
    ['brands:whatsapp', 'fa-brands fa-whatsapp', 'brands:'],
]);

it('test_invalid_style_throws_in_testing', function (string $template, string $value) {
    expect(config('app.env'))->toBe('testing');

    $failure = bladeRenderFailure($template);

    expect($failure)->toBeInstanceOf(InvalidArgumentException::class)
        ->and($failure->getMessage())->toContain("\"{$value}\"");
})->with([
    'variant' => ['<x-jetax-icon name="paw" variant="outlined" />', 'outlined'],
    'prefix' => ['<x-jetax-icon name="outlined:paw" />', 'outlined'],
]);

it('test_invalid_style_falls_back_to_solid_with_warning_in_production', function (string $template) {
    config(['app.env' => 'production']);
    Log::spy();

    $html = Blade::render($template);

    expect($html)->toContain('fa-solid fa-paw')->not->toContain('outlined');
    Log::shouldHaveReceived('warning')->once();
})->with([
    'variant' => ['<x-jetax-icon name="paw" variant="outlined" />'],
    'prefix' => ['<x-jetax-icon name="outlined:paw" />'],
]);

it('test_prefix_equal_to_variant_renders_without_warning', function () {
    Log::spy();

    $html = Blade::render('<x-jetax-icon name="regular:bell" variant="regular" />');

    expect($html)->toContain('fa-regular fa-bell')->not->toContain('regular:');
    Log::shouldNotHaveReceived('warning');
});

it('test_prefix_different_from_variant_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-icon name="regular:bell" variant="solid" />'))
        ->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_prefix_different_from_variant_falls_back_to_solid_in_production', function () {
    config(['app.env' => 'production']);
    Log::spy();

    $html = Blade::render('<x-jetax-icon name="regular:bell" variant="solid" />');

    expect($html)
        ->toContain('fa-solid fa-bell')
        ->not->toContain('fa-regular');
    Log::shouldHaveReceived('warning')->once();
});

it('test_consumer_attributes_reach_element', function () {
    $html = Blade::render('<x-jetax-icon name="paw" class="text-primary mr-1" data-testid="pet-icon" data-role="glyph" />');

    expect($html)
        ->toContain('text-primary mr-1')
        ->toContain('fa-solid fa-paw')
        ->toContain('data-testid="pet-icon"')
        ->toContain('data-role="glyph"');
});

it('test_constructor_has_no_weight_fill_or_style', function () {
    $parameters = array_map(
        fn (ReflectionParameter $parameter) => $parameter->getName(),
        (new ReflectionMethod(Icon::class, '__construct'))->getParameters(),
    );

    expect($parameters)
        ->toBe(['name', 'size', 'variant'])
        ->not->toContain('weight')
        ->not->toContain('fill')
        ->not->toContain('style');
});

/*
|--------------------------------------------------------------------------
| Tamanho por classe e numérico (SPEC jetax-f2, RF-02, CT-05)
|--------------------------------------------------------------------------
*/

it('test_named_size_emits_class_without_inline_style', function (string $size, string $class) {
    $html = Blade::render("<x-jetax-icon name=\"paw\" size=\"{$size}\" />");

    expect($html)
        ->toContain($class)
        ->not->toContain('style=')
        ->not->toContain('font-variation-settings');
})->with([
    ['sm', 'text-[12px]'],
    ['md', 'text-[15px]'],
    ['lg', 'text-[18px]'],
    ['xl', 'text-[24px]'],
]);

it('test_default_size_is_md', function () {
    $html = Blade::render('<x-jetax-icon name="paw" />');

    expect($html)
        ->toContain('text-[15px]')
        ->not->toContain('style=')
        ->not->toContain('font-variation-settings');
});

it('test_numeric_size_emits_inline_font_size_divided_by_factor', function (string $size, string $style) {
    $html = Blade::render("<x-jetax-icon name=\"paw\" size=\"{$size}\" />");

    expect($html)
        ->toContain("style=\"{$style}\"")
        ->not->toContain('text-[')
        ->not->toContain('font-variation-settings');
})->with([
    ['27', 'font-size:20px'],
    ['16', 'font-size:12px'],
]);

it('test_numeric_size_accepts_integer_binding', function () {
    $html = Blade::render('<x-jetax-icon name="paw" :size="27" />');

    expect($html)->toContain('style="font-size:20px"')->not->toContain('text-[');
});
