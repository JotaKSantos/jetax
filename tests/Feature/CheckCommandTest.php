<?php

use Illuminate\Support\Facades\File;

test('test_no_warnings_when_up_to_date', function () {
    $publishedPath = $this->app->resourcePath('views/vendor/jetax');
    $packageViewsPath = __DIR__.'/../../resources/views';

    // Copiar todas as views do pacote para o caminho publicado
    File::copyDirectory($packageViewsPath, $publishedPath);

    $this->artisan('jetax:check')
        ->assertSuccessful();

    // Limpar após o teste
    File::deleteDirectory($publishedPath);
});

test('test_warns_when_published_view_is_stale', function () {
    $publishedPath = $this->app->resourcePath('views/vendor/jetax');
    $packageViewsPath = __DIR__.'/../../resources/views';

    // Copiar todas as views do pacote para o caminho publicado
    File::copyDirectory($packageViewsPath, $publishedPath);

    // Encontrar a primeira view publicada e modificá-la para simular "stale"
    $firstView = collect(File::allFiles($publishedPath))
        ->filter(fn ($file) => $file->getExtension() === 'php')
        ->first();

    expect($firstView)->not->toBeNull();

    File::append($firstView->getRealPath(), "\n{{-- view modificada para teste --}}");

    $this->artisan('jetax:check')
        ->assertFailed();

    // Limpar após o teste
    File::deleteDirectory($publishedPath);
});
