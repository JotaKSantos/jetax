<?php

use Jetax\DesignSystem\Support\FontAwesome;

/*
|--------------------------------------------------------------------------
| Manifesto Font Awesome Free (SPEC jetax-f2, RF-08, CT-02)
|--------------------------------------------------------------------------
|
| Manifesto congelado da versão npm fixada em RNF-03 (6.7.2), gerado por
| bin/generate-fontawesome-manifest.php. Só nomes canônicos, sem aliases.
|
*/

it('test_manifest_lives_at_contract_path_with_pinned_version', function () {
    $path = dirname(__DIR__, 2).'/resources/icons/fontawesome-free.json';

    expect($path)->toBeFile()
        ->and(realpath(FontAwesome::MANIFEST_PATH))->toBe(realpath($path));

    $manifest = json_decode(file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

    expect(array_keys($manifest))->toBe(['version', 'solid', 'regular', 'brands'])
        ->and($manifest['version'])->toBe('6.7.2');
});

it('test_manifest_style_lists_are_not_empty_and_sorted', function (string $style) {
    $list = FontAwesome::manifest()[$style];
    $sorted = $list;
    sort($sorted, SORT_STRING);

    expect($list)->not->toBeEmpty()
        ->and($list)->toBe($sorted)
        ->and($list)->toBe(array_values(array_unique($list)))
        ->and($list)->each->toBeString()->not->toStartWith('fa-');
})->with(['solid', 'regular', 'brands']);

it('test_paw_is_solid', function () {
    expect(FontAwesome::manifest()['solid'])->toContain('paw')
        ->and(FontAwesome::has('paw', 'solid'))->toBeTrue();
});

it('test_whatsapp_is_brands_only', function () {
    expect(FontAwesome::manifest()['brands'])->toContain('whatsapp')
        ->and(FontAwesome::manifest()['solid'])->not->toContain('whatsapp')
        ->and(FontAwesome::has('whatsapp', 'brands'))->toBeTrue()
        ->and(FontAwesome::has('whatsapp', 'solid'))->toBeFalse();
});

it('test_alias_close_is_in_no_list', function () {
    foreach (FontAwesome::STYLES as $style) {
        expect(FontAwesome::manifest()[$style])->not->toContain('close')
            ->and(FontAwesome::has('close', $style))->toBeFalse();
    }

    expect(FontAwesome::has('xmark', 'solid'))->toBeTrue();
});

it('test_generator_documents_its_command', function () {
    $script = file_get_contents(dirname(__DIR__, 2).'/bin/generate-fontawesome-manifest.php');

    expect($script)->toContain('php bin/generate-fontawesome-manifest.php')
        ->toContain('icon-families.json')
        ->toContain('@sha256:');
});
