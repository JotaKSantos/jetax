<?php

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Define o TestCase padrão para todos os testes do pacote Jetax.
| Utiliza Orchestra Testbench para simular o ambiente Laravel.
|
*/

uses(TestCase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Tokens do jetax.css
|--------------------------------------------------------------------------
|
| Lê as declarações `--color-*` de um bloco do jetax.css: '@theme' (tema
| claro) ou ':root.dark' (tema escuro). Devolve nome do token => valor,
| com o valor em minúsculas e sem espaços.
|
*/

/**
 * @return array<string, string>
 */
function jetaxCssTokens(string $block): array
{
    $css = file_get_contents(__DIR__.'/../resources/css/jetax.css');
    $css = preg_replace('#/\*.*?\*/#s', '', $css);

    preg_match('/'.preg_quote($block, '/').'\s*\{([^}]*)\}/', $css, $match);

    if ($match === []) {
        throw new RuntimeException("Bloco {$block} não encontrado em jetax.css.");
    }

    preg_match_all('/--color-([a-z0-9-]+)\s*:\s*([^;]+);/', $match[1], $declarations, PREG_SET_ORDER);

    $tokens = [];

    foreach ($declarations as [, $name, $value]) {
        $tokens[$name] = strtolower(preg_replace('/\s+/', '', $value));
    }

    return $tokens;
}

/*
|--------------------------------------------------------------------------
| Causa raiz de exceção
|--------------------------------------------------------------------------
|
| Exceção lançada no construtor de um componente chega embrulhada em
| ViewException quando o componente é renderizado por Blade. Devolve a
| exceção mais interna da cadeia.
|
*/

function rootCause(Throwable $exception): Throwable
{
    while ($exception->getPrevious() !== null) {
        $exception = $exception->getPrevious();
    }

    return $exception;
}

/**
 * Renderiza o template e devolve a causa raiz da exceção, ou null se renderizou.
 */
function bladeRenderFailure(string $template): ?Throwable
{
    try {
        Blade::render($template);
    } catch (Throwable $exception) {
        return rootCause($exception);
    }

    return null;
}

/*
|--------------------------------------------------------------------------
| Recorte de tag no HTML
|--------------------------------------------------------------------------
|
| Devolve a primeira tag de abertura `<tag ...>` do HTML renderizado, ou a
| primeira que casar com o atributo informado (ex.: 'type="checkbox"').
|
*/

function htmlTag(string $html, string $tag, string $containing = ''): string
{
    preg_match_all('/<'.preg_quote($tag, '/').'\b[^>]*>/s', $html, $matches);

    foreach ($matches[0] as $match) {
        if ($containing === '' || str_contains($match, $containing)) {
            return $match;
        }
    }

    throw new RuntimeException("Tag <{$tag}> não encontrada no HTML.");
}

/**
 * Devolve o valor do atributo class de uma tag de abertura.
 */
function tagClass(string $tag): string
{
    preg_match('/\sclass="([^"]*)"/', $tag, $match);

    return $match[1] ?? '';
}
