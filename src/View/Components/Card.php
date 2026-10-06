<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Valores de padding aceitos pela prop e a classe equivalente.
     */
    public const PADDING_CLASSES = [
        '0' => 'p-0',
        '0px' => 'p-0',
        '0rem' => 'p-0',
        '0.5rem' => 'p-2',
        '0.75rem' => 'p-3',
        '1rem' => 'p-4',
        '1.25rem' => 'p-5',
        '1.5rem' => 'p-6',
        '2rem' => 'p-8',
    ];

    /**
     * Cria uma nova instância do componente de card.
     */
    public function __construct(
        public string $padding = '1.5rem',
        public bool $featured = false,
        public bool $bordered = false,
        public string $headerClass = '',
        public string $footerClass = '',
    ) {}

    /**
     * Indica se uma classe utilitária é de padding (p-*, px-*, py-*, pt-*...),
     * inclusive com prefixo de variante (md:p-6) e marcador de importância.
     */
    public static function isPaddingClass(string $class): bool
    {
        return preg_match('/^(?:[a-z0-9-]+:)*!?p[xytrblse]?-[^\s]+$/', $class) === 1;
    }

    /**
     * Separa as classes do consumidor entre as de padding, que vão ao wrapper
     * do conteúdo, e as demais, que ficam no contêiner.
     *
     * @return array{padding: string, container: string}
     */
    public static function splitConsumerClasses(string $classes): array
    {
        $padding = [];
        $container = [];

        foreach (preg_split('/\s+/', trim($classes), -1, PREG_SPLIT_NO_EMPTY) as $class) {
            if (self::isPaddingClass($class)) {
                $padding[] = $class;
            } else {
                $container[] = $class;
            }
        }

        return ['padding' => implode(' ', $padding), 'container' => implode(' ', $container)];
    }

    /**
     * Classe de padding do wrapper do conteúdo a partir da prop padding.
     */
    public function paddingClass(): string
    {
        $value = trim($this->padding);

        return self::PADDING_CLASSES[$value] ?? 'p-['.str_replace(' ', '_', $value).']';
    }

    /**
     * Classes do wrapper do conteúdo: o padding da prop, substituído pelo
     * padding base do consumidor quando ele informa p-* sem prefixo.
     */
    public function bodyClasses(string $consumerPadding = ''): string
    {
        $classes = preg_split('/\s+/', trim($consumerPadding), -1, PREG_SPLIT_NO_EMPTY);
        $overridesBase = collect($classes)->contains(fn (string $class): bool => preg_match('/^!?p-/', $class) === 1);

        return trim(($overridesBase ? '' : $this->paddingClass()).' '.implode(' ', $classes));
    }

    /**
     * Retorna as classes CSS do container baseadas na variante.
     */
    public function containerClasses(): string
    {
        $base = 'rounded-xl overflow-hidden bg-surface-container-lowest';

        if ($this->featured) {
            return $base.' shadow-sm shadow-on-surface/5 dark:shadow-lg dark:shadow-black/20 dark:border dark:border-outline-variant border-t-4 border-error';
        }

        if ($this->bordered) {
            return $base.' shadow-sm border border-outline-variant';
        }

        return $base.' shadow-sm shadow-on-surface/5 dark:shadow-lg dark:shadow-black/20 dark:border dark:border-outline-variant';
    }

    /**
     * Retorna as classes CSS do header baseado na variante, mescladas com o
     * override do consumidor via prop headerClass.
     */
    public function headerClasses(): string
    {
        $typography = 'font-headline font-bold text-sm uppercase tracking-wide flex items-center gap-2';

        $base = $this->featured
            ? 'px-6 py-4 bg-error/5 dark:bg-error/10 border-b border-error/20 text-error '.$typography
            : 'px-6 py-4 bg-secondary/5 dark:bg-primary/5 border-b border-outline-variant text-secondary dark:text-primary '.$typography;

        return trim($base.' '.$this->headerClass);
    }

    /**
     * Retorna as classes CSS do footer mescladas com o override do consumidor
     * via prop footerClass.
     */
    public function footerClasses(): string
    {
        return trim('bg-surface-container-low px-6 py-4 '.$this->footerClass);
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.card');
    }
}
