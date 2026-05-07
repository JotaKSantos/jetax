<?php

use Illuminate\Support\Facades\Route;
use Jetax\DesignSystem\Docs\ComponentRegistry;

Route::prefix('docs')->group(function () {
    Route::get('/', function () {
        return view('jetax::docs.index', [
            'groups' => ComponentRegistry::all(),
        ]);
    })->name('jetax.docs.index');

    Route::get('/getting-started', function () {
        return view('jetax::docs.getting-started');
    })->name('jetax.docs.getting-started');

    Route::get('/customization', function () {
        return view('jetax::docs.customization');
    })->name('jetax.docs.customization');

    Route::get('/preview/auth-layout', function () {
        return view('jetax::docs.previews.auth-layout');
    })->name('jetax.docs.preview.auth-layout');

    Route::get('/components/{component}', function (string $component) {
        $data = ComponentRegistry::find($component);

        abort_if($data === null, 404, "Componente '{$component}' não encontrado.");

        return view('jetax::docs.components.show', [
            'componentData' => $data,
        ]);
    })->name('jetax.docs.component');
});
