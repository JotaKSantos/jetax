<?php

/*
|--------------------------------------------------------------------------
| Varredura de cor hexadecimal arbitrária (SPEC jetax-f1-alinhamento-v2, RNF-02)
|--------------------------------------------------------------------------
|
| Nenhum utilitário `(text|bg|border|ring|from|to|fill|stroke)-[#…]`, com ou
| sem prefixo de variante, em resources/views/components/** e src/**. Linha de
| base da T05 (v1.1.2): 102 ocorrências em 67 linhas de 23 arquivos.
|
*/

/**
 * @return array<int, string> uma entrada `arquivo:linha: utilitário` por ocorrência
 */
function hexLiteralOccurrences(): array
{
    $root = dirname(__DIR__, 2);
    $occurrences = [];

    foreach (['resources/views/components', 'src'] as $directory) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("{$root}/{$directory}", FilesystemIterator::SKIP_DOTS));

        foreach ($iterator as $file) {
            if (! $file->isFile() || ! preg_match('/\.php$/', $file->getFilename())) {
                continue;
            }

            foreach (file($file->getPathname()) as $index => $line) {
                if (preg_match_all('/(?:text|bg|border|ring|from|to|fill|stroke)-\[#[^\]]*\]/', $line, $matches)) {
                    $relative = substr($file->getPathname(), strlen($root) + 1);

                    foreach ($matches[0] as $match) {
                        $occurrences[] = "{$relative}:".($index + 1).": {$match}";
                    }
                }
            }
        }
    }

    return $occurrences;
}

it('test_package_has_no_arbitrary_hex_color_utility', function () {
    expect(hexLiteralOccurrences())->toBe([]);
});

it('test_scan_detects_hex_utility_with_variant_prefix', function () {
    $pattern = '/(?:text|bg|border|ring|from|to|fill|stroke)-\[#[^\]]*\]/';

    expect(preg_match($pattern, 'checked:border-[#0061a5]'))->toBe(1)
        ->and(preg_match($pattern, 'before:bg-[#0D99FF]'))->toBe(1)
        ->and(preg_match($pattern, 'dark:fill-[#fff]'))->toBe(1)
        ->and(preg_match($pattern, 'checked:border-primary'))->toBe(0);
});

it('test_radio_checked_state_uses_primary_token', function () {
    $html = (string) $this->blade('<x-jetax-radio label="Sim" name="opcao" value="1" />');

    expect($html)->toContain('checked:border-primary')
        ->toContain('focus:ring-primary')
        ->toContain('border-outline-variant')
        ->not->toContain('[#');
});
