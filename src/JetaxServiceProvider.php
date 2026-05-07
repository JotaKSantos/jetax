<?php

namespace Jetax\DesignSystem;

use Illuminate\Support\ServiceProvider;
use Jetax\DesignSystem\Console\JetaxCheckCommand;
use Jetax\DesignSystem\Console\JetaxInstallCommand;
use Jetax\DesignSystem\Console\JetaxSeedPlaygroundCommand;
use Jetax\DesignSystem\Docs\Playground\ClientesTable;
use Livewire\Livewire;
use Jetax\DesignSystem\View\Components\Alert;
use Jetax\DesignSystem\View\Components\Card;
use Jetax\DesignSystem\View\Components\AuthLayout;
use Jetax\DesignSystem\View\Components\Avatar;
use Jetax\DesignSystem\View\Components\Badge;
use Jetax\DesignSystem\View\Components\Breadcrumbs;
use Jetax\DesignSystem\View\Components\Button;
use Jetax\DesignSystem\View\Components\Checkbox;
use Jetax\DesignSystem\View\Components\Color;
use Jetax\DesignSystem\View\Components\Currency;
use Jetax\DesignSystem\View\Components\DetailSummary;
use Jetax\DesignSystem\View\Components\Dialog;
use Jetax\DesignSystem\View\Components\EmptyState;
use Jetax\DesignSystem\View\Components\Dropdown;
use Jetax\DesignSystem\View\Components\DropdownItem;
use Jetax\DesignSystem\View\Components\DropdownSeparator;
use Jetax\DesignSystem\View\Components\Editor;
use Jetax\DesignSystem\View\Components\FormGroup;
use Jetax\DesignSystem\View\Components\Input;
use Jetax\DesignSystem\View\Components\Layout;
use Jetax\DesignSystem\View\Components\Modal;
use Jetax\DesignSystem\View\Components\Offcanvas;
use Jetax\DesignSystem\View\Components\Pagination;
use Jetax\DesignSystem\View\Components\Pin;
use Jetax\DesignSystem\View\Components\Progress;
use Jetax\DesignSystem\View\Components\Radio;
use Jetax\DesignSystem\View\Components\Range;
use Jetax\DesignSystem\View\Components\Select;
use Jetax\DesignSystem\View\Components\Skeleton;
use Jetax\DesignSystem\View\Components\Spinner;
use Jetax\DesignSystem\View\Components\Tabs;
use Jetax\DesignSystem\View\Components\Tag;
use Jetax\DesignSystem\View\Components\Textarea;
use Jetax\DesignSystem\View\Components\Time;
use Jetax\DesignSystem\View\Components\ToastContainer;
use Jetax\DesignSystem\View\Components\Popover;
use Jetax\DesignSystem\View\Components\Tooltip;
use Jetax\DesignSystem\View\Components\Toggle;
use Jetax\DesignSystem\View\Components\ListGroup;
use Jetax\DesignSystem\View\Components\ListGroupItem;
use Jetax\DesignSystem\View\Components\StatsCard;
use Jetax\DesignSystem\View\Components\Timeline;
use Jetax\DesignSystem\View\Components\TimelineItem;
use Jetax\DesignSystem\View\Components\Upload;
use Jetax\DesignSystem\View\Components\ActivityFeed;
use Jetax\DesignSystem\View\Components\ActivityFeedItem;
use Jetax\DesignSystem\View\Components\Table;
use Jetax\DesignSystem\View\Components\Accordion;
use Jetax\DesignSystem\View\Components\AccordionItem;
use Jetax\DesignSystem\View\Components\Carousel;
use Jetax\DesignSystem\View\Components\CarouselItem;
use Jetax\DesignSystem\View\Components\Collapse;
use Jetax\DesignSystem\View\Components\PageHeader;
use Jetax\DesignSystem\View\Components\DocsLayout;
use Jetax\DesignSystem\View\Components\DocsPreviewSection;
use Jetax\DesignSystem\View\Components\BackToTop;
use Jetax\DesignSystem\View\Components\Clipboard;
use Jetax\DesignSystem\View\Components\Dismissable;
use Jetax\DesignSystem\View\Components\Icon;
use Jetax\DesignSystem\View\Components\Rating;
use Jetax\DesignSystem\View\Components\Step;
use Jetax\DesignSystem\View\Components\StepItem;

class JetaxServiceProvider extends ServiceProvider
{
    /**
     * Registra os serviços do pacote no container da aplicação.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/jetax.php',
            'jetax'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/jetax-data-table.php',
            'jetax-data-table'
        );
    }

    /**
     * Inicializa os serviços do pacote após o boot da aplicação.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'jetax');

        $this->loadViewComponentsAs('jetax', [
            Layout::class,
            AuthLayout::class,
            Button::class,
            Avatar::class,
            Breadcrumbs::class,
            Tabs::class,
            Pagination::class,
            Dropdown::class,
            DropdownItem::class,
            DropdownSeparator::class,
            Input::class,
            Select::class,
            Textarea::class,
            Checkbox::class,
            Radio::class,
            Toggle::class,
            FormGroup::class,
            Color::class,
            Currency::class,
            Pin::class,
            Range::class,
            Tag::class,
            Time::class,
            Upload::class,
            Editor::class,
            Alert::class,
            Badge::class,
            Spinner::class,
            Skeleton::class,
            Progress::class,
            ToastContainer::class,
            Modal::class,
            Dialog::class,
            Offcanvas::class,
            Tooltip::class,
            Popover::class,
            EmptyState::class,
            Card::class,
            StatsCard::class,
            DetailSummary::class,
            ListGroup::class,
            ListGroupItem::class,
            Timeline::class,
            TimelineItem::class,
            ActivityFeed::class,
            ActivityFeedItem::class,
            Table::class,
            Accordion::class,
            AccordionItem::class,
            Carousel::class,
            CarouselItem::class,
            Collapse::class,
            PageHeader::class,
            Icon::class,
            BackToTop::class,
            Clipboard::class,
            Dismissable::class,
            Rating::class,
            Step::class,
            StepItem::class,
        ]);

        if ($this->app->environment('local', 'testing') || $this->app->runningInConsole()) {
            $this->loadRoutesFrom(__DIR__.'/../routes/docs.php');
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            $this->loadViewComponentsAs('jetax', [
                DocsLayout::class,
                DocsPreviewSection::class,
            ]);

            Livewire::component('jetax-docs-clientes-table', ClientesTable::class);
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                JetaxCheckCommand::class,
                JetaxInstallCommand::class,
                JetaxSeedPlaygroundCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/jetax.php' => config_path('jetax.php'),
            ], 'jetax-config');

            $this->publishes([
                __DIR__.'/../config/jetax-data-table.php' => config_path('jetax-data-table.php'),
            ], 'jetax-data-table-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/jetax'),
            ], 'jetax-views');

            $this->publishes([
                __DIR__.'/../resources/dist' => public_path('vendor/jetax'),
            ], 'jetax-assets');

            $this->publishes([
                __DIR__.'/../resources/css' => resource_path('css/vendor/jetax'),
            ], 'jetax-css-source');
        }
    }
}
