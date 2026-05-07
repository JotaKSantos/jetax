<?php

use Jetax\DesignSystem\View\Components\Avatar;

it('test_renders_image_when_src_provided', function () {
    $view = $this->blade('<x-jetax-avatar src="https://example.com/foto.jpg" name="João Silva" />');

    $view->assertSee('<img', false);
    $view->assertSee('https://example.com/foto.jpg', false);
});

it('test_renders_initials_when_no_src', function () {
    $view = $this->blade('<x-jetax-avatar name="João Silva" />');

    $view->assertDontSee('<img', false);
    $view->assertSee('JS', false);
});

it('test_initials_extraction', function () {
    $avatar = new Avatar(name: 'João Silva');
    expect($avatar->initials)->toBe('JS');

    $avatar = new Avatar(name: 'Maria');
    expect($avatar->initials)->toBe('M');

    $avatar = new Avatar(name: 'Ana Clara Souza');
    expect($avatar->initials)->toBe('AS');

    $avatar = new Avatar(name: '');
    expect($avatar->initials)->toBe('?');
});

it('test_all_6_sizes_applied', function () {
    $sizes = [
        'xs' => ['w-6', 'h-6'],
        'sm' => ['w-8', 'h-8'],
        'md' => ['w-10', 'h-10'],
        'lg' => ['w-12', 'h-12'],
        'xl' => ['w-16', 'h-16'],
        'xxl' => ['w-24', 'h-24'],
    ];

    foreach ($sizes as $size => [$width, $height]) {
        $view = $this->blade("<x-jetax-avatar name=\"Teste\" size=\"{$size}\" />");
        $view->assertSee($width, false);
        $view->assertSee($height, false);
    }
});

it('test_status_dot_rendered', function () {
    $view = $this->blade('<x-jetax-avatar name="João" status="online" />');
    $view->assertSee('bg-emerald-500', false);
    $view->assertSee('ring-4', false);
    $view->assertSee('ring-white', false);

    $view = $this->blade('<x-jetax-avatar name="Maria" status="offline" />');
    $view->assertSee('bg-slate-400', false);

    $view = $this->blade('<x-jetax-avatar name="Carlos" status="blocked" />');
    $view->assertSee('bg-rose-500', false);

    $view = $this->blade('<x-jetax-avatar name="Sem Status" />');
    $view->assertDontSee('ring-4', false);
});

it('test_status_positions', function () {
    $onlineView = $this->blade('<x-jetax-avatar name="Online" status="online" />');
    $onlineView->assertSee('top-0', false);
    $onlineView->assertSee('right-0', false);
    $onlineView->assertDontSee('bottom-0', false);

    $blockedView = $this->blade('<x-jetax-avatar name="Bloqueado" status="blocked" />');
    $blockedView->assertSee('bottom-0', false);
    $blockedView->assertSee('right-0', false);
    $blockedView->assertDontSee('top-0 right-0', false);
});

it('test_square_format', function () {
    $roundedView = $this->blade('<x-jetax-avatar name="Teste" :rounded="true" />');
    $roundedView->assertSee('rounded-full', false);
    $roundedView->assertDontSee('rounded-2xl', false);

    $squareView = $this->blade('<x-jetax-avatar name="Teste" :rounded="false" />');
    $squareView->assertSee('rounded-2xl', false);
    $squareView->assertDontSee('rounded-full', false);
});
