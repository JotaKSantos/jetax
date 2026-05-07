<?php

use Illuminate\Support\Facades\File;

test('test_views_published_to_correct_path', function () {
    $publishPath = resource_path('views/vendor/jetax');

    if (File::isDirectory($publishPath)) {
        File::deleteDirectory($publishPath);
    }

    $this->artisan('vendor:publish', [
        '--tag' => 'jetax-views',
        '--force' => true,
    ]);

    expect(File::isDirectory($publishPath))->toBeTrue()
        ->and(File::exists($publishPath.'/components/badge.blade.php'))->toBeTrue();
});

test('test_published_view_overrides_package_view', function () {
    $publishPath = resource_path('views/vendor/jetax');

    $this->artisan('vendor:publish', [
        '--tag' => 'jetax-views',
        '--force' => true,
    ]);

    $publishedBadge = $publishPath.'/components/badge.blade.php';

    expect(File::exists($publishedBadge))->toBeTrue();

    $originalContent = File::get($publishedBadge);
    File::put($publishedBadge, "CUSTOM_OVERRIDE_MARKER");

    try {
        view()->prependNamespace('jetax', $publishPath);

        $this->artisan('view:clear');

        $html = view('jetax::components.badge')->render();

        expect($html)->toContain('CUSTOM_OVERRIDE_MARKER');
    } finally {
        File::put($publishedBadge, $originalContent);
    }
});

test('test_config_published_to_correct_path', function () {
    $publishPath = config_path('jetax.php');

    if (File::exists($publishPath)) {
        File::delete($publishPath);
    }

    $this->artisan('vendor:publish', [
        '--tag' => 'jetax-config',
        '--force' => true,
    ]);

    expect(File::exists($publishPath))->toBeTrue();
});

test('test_assets_published_to_public', function () {
    $publishPath = public_path('vendor/jetax');

    if (File::isDirectory($publishPath)) {
        File::deleteDirectory($publishPath);
    }

    $this->artisan('vendor:publish', [
        '--tag' => 'jetax-assets',
        '--force' => true,
    ]);

    expect(File::exists($publishPath.'/jetax.css'))->toBeTrue();
});
