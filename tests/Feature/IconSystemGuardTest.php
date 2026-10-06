<?php

/*
|--------------------------------------------------------------------------
| Sistema de ícones intocado (SPEC jetax-f1-alinhamento-v2, RNF-06, AC7)
|--------------------------------------------------------------------------
|
| `material-symbols-outlined` em resources/views/components + src só cresce
| pelos componentes novos da F1: chip, button-group e o `icon` do
| page-header. Linha de base da T05 (v1.1.2): 70 ocorrências em 31 arquivos.
| Nenhum arquivo do pacote referencia Font Awesome.
|
*/

const ICON_BASELINE_OCCURRENCES = 70;

const ICON_NEW_COMPONENT_FILES = [
    'resources/views/components/chip.blade.php',
    'resources/views/components/button-group.blade.php',
    'resources/views/components/page-header.blade.php',
    'src/View/Components/Chip.php',
    'src/View/Components/ButtonGroup.php',
    'src/View/Components/PageHeader.php',
];

/**
 * Arquivos `.php` de uma lista de diretórios do pacote, com caminho relativo.
 *
 * @param  array<int, string>  $directories
 * @return array<string, string> caminho relativo => conteúdo
 */
function iconGuardFiles(array $directories): array
{
    $root = dirname(__DIR__, 2);
    $files = [];

    foreach ($directories as $directory) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("{$root}/{$directory}", FilesystemIterator::SKIP_DOTS));

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $files[substr($file->getPathname(), strlen($root) + 1)] = file_get_contents($file->getPathname());
            }
        }
    }

    ksort($files);

    return $files;
}

it('test_material_symbols_grow_only_through_new_components', function () {
    $existing = 0;
    $new = 0;

    foreach (iconGuardFiles(['resources/views/components', 'src']) as $path => $content) {
        $count = substr_count($content, 'material-symbols-outlined');

        if (in_array($path, ICON_NEW_COMPONENT_FILES, true)) {
            $new += $count;
        } else {
            $existing += $count;
        }
    }

    expect($existing)->toBeLessThanOrEqual(ICON_BASELINE_OCCURRENCES)
        ->and($new)->toBeGreaterThan(0);
});

it('test_page_header_icon_uses_material_symbols', function () {
    $html = (string) $this->blade('<x-jetax-page-header title="Clientes" icon="pets" />');

    expect($html)->toContain('material-symbols-outlined')->toContain('pets');
});

it('test_package_never_references_font_awesome', function () {
    $offending = [];

    foreach (iconGuardFiles(['resources', 'src', 'config']) as $path => $content) {
        if (preg_match('/(?<![\w-])fa-[a-z]|@fortawesome|font-awesome/i', $content, $match)) {
            $offending[] = "{$path}: {$match[0]}";
        }
    }

    expect($offending)->toBe([]);
});
