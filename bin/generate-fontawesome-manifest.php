<?php

/*
|--------------------------------------------------------------------------
| Gerador do manifesto Font Awesome Free (SPEC jetax-f2, RF-08, CT-02)
|--------------------------------------------------------------------------
|
| Gera resources/icons/fontawesome-free.json a partir dos metadados do pacote
| npm @fortawesome/fontawesome-free na versão fixada (RNF-03). O manifesto
| muda só junto com a troca dessa versão.
|
| Uso (container do digest, a partir da raiz do Jetax):
|
|   VERSION=6.7.2
|   mkdir -p /tmp/fa && cd /tmp/fa
|   curl -sSfLo fa.tgz https://registry.npmjs.org/@fortawesome/fontawesome-free/-/fontawesome-free-$VERSION.tgz
|   tar xzf fa.tgz && cd -
|   docker run --rm -u "$(id -u):$(id -g)" \
|     -v /tmp/fa/package:/fa:ro -v "$PWD":/app -w /app \
|     laravelsail/php84-composer@sha256:a2716e93e577c80bca7551126056446c1e06cb141af652ee6932537158108400 \
|     php bin/generate-fontawesome-manifest.php /fa/metadata
|
| Argumentos: <dir metadata/ do pacote npm extraído> [arquivo de saída]. Sem o
| segundo argumento, grava em resources/icons/fontawesome-free.json.
|
| Fonte: <pacote>/metadata/icon-families.json (a 6.x não traz metadata/icons.json).
| Chaves do objeto = nomes canônicos; aliases ficam em aliases.names e não são
| chaves, então ficam de fora por construção. Estilos Free =
| familyStylesByLicense.free[*] com family "classic". Versão = "version" de
| <pacote>/package.json. Saída: {"version","solid","regular","brands"}, listas
| ordenadas (SORT_STRING), JSON determinístico.
|
*/

if ($argc < 2 || $argc > 3) {
    fwrite(STDERR, "uso: php bin/generate-fontawesome-manifest.php <dir metadata/ do pacote npm> [arquivo de saída]\n");
    exit(2);
}

$metadataDir = rtrim($argv[1], '/');
$outFile = $argv[2] ?? dirname(__DIR__).'/resources/icons/fontawesome-free.json';

$package = json_decode((string) file_get_contents(dirname($metadataDir).'/package.json'), true, flags: JSON_THROW_ON_ERROR);
$families = json_decode((string) file_get_contents("{$metadataDir}/icon-families.json"), true, flags: JSON_THROW_ON_ERROR);

$styles = ['solid' => [], 'regular' => [], 'brands' => []];

foreach ($families as $name => $icon) {
    foreach ($icon['familyStylesByLicense']['free'] ?? [] as $familyStyle) {
        if (($familyStyle['family'] ?? '') === 'classic' && isset($styles[$familyStyle['style']])) {
            // json_decode transforma as chaves "0".."9" em int: o nome volta a ser string.
            $styles[$familyStyle['style']][] = (string) $name;
        }
    }
}

foreach ($styles as &$list) {
    $list = array_values(array_unique($list));
    sort($list, SORT_STRING);
}
unset($list);

if (! is_dir(dirname($outFile))) {
    mkdir(dirname($outFile), 0755, true);
}

$manifest = ['version' => (string) $package['version']] + $styles;
file_put_contents($outFile, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)."\n");

foreach ($styles as $style => $list) {
    echo "{$style}\t".count($list)."\n";
}
