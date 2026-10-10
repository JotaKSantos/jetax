<?php

/**
 * Ícone do toast-container trocado por binding de classe (SPEC jetax-f2, RF-07).
 */
function toastIconElement(string $html): string
{
    preg_match('/<i\b[^>]*:class="\{[^"]*fa-circle-check[^"]*\}"[^>]*>/s', $html, $match);

    return $match[0] ?? '';
}

it('test_icon_binds_font_awesome_class_per_variant', function () {
    $html = (string) $this->blade('<x-jetax-toast-container />');
    $icon = toastIconElement($html);

    expect($icon)->not->toBe('')
        ->toContain('fa-solid')
        ->toContain("'fa-circle-check': toast.variant === 'success'")
        ->toContain("'fa-circle-exclamation': toast.variant === 'error'")
        ->toContain("'fa-triangle-exclamation': toast.variant === 'warning'")
        ->toContain("'fa-circle-info': !toast.variant || toast.variant === 'info'")
        ->toContain('aria-hidden="true"');
});

it('test_icon_element_has_no_text', function () {
    $html = (string) $this->blade('<x-jetax-toast-container />');

    expect($html)->toMatch('/<i\b[^>]*fa-circle-check[^>]*>\s*<\/i>/s');
});

it('test_no_font_awesome_element_uses_x_text_or_x_html', function () {
    $html = (string) $this->blade('<x-jetax-toast-container />');

    preg_match_all('/<[a-z][\w-]*\b[^>]*\bfa-[^>]*>/s', $html, $elements);

    expect($elements[0])->not->toBeEmpty();

    foreach ($elements[0] as $element) {
        expect($element)->not->toContain('x-text')
            ->not->toContain('x-html');
    }
});

it('test_close_button_uses_font_awesome', function () {
    $html = (string) $this->blade('<x-jetax-toast-container />');

    expect(htmlTag($html, 'i', 'fa-xmark'))->toContain('fa-solid fa-xmark')
        ->toContain('aria-hidden="true"');
});

it('test_file_has_no_material_symbols', function () {
    $source = file_get_contents(__DIR__.'/../../resources/views/components/toast-container.blade.php');

    expect($source)->not->toContain('material-symbols')
        ->and((string) $this->blade('<x-jetax-toast-container />'))->not->toContain('material-symbols');
});
