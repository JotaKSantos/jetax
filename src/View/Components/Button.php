<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use InvalidArgumentException;
use Jetax\DesignSystem\Support\FontAwesome;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class Button extends Component
{
    use ValidatesVariant;

    /**
     * Estilos de botão disponíveis.
     */
    public const STYLES = ['solid', 'rounded', 'outline', 'outline-rounded', 'soft', 'soft-rounded'];

    /**
     * Cores disponíveis.
     */
    public const COLORS = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark', 'light'];

    /**
     * Cor livre: o fundo vem do token CSS informado em `color-token` (`var(--color-<token>)`).
     */
    public const CUSTOM_COLOR = 'custom';

    /**
     * Tamanhos disponíveis.
     */
    public const SIZES = ['sm', 'md', 'lg'];

    /**
     * Classe de tamanho do glifo por `size` do botão (JETAX-014 c, SPEC jetax-f2 RF-04, CT-05):
     * valores fixos que acompanham a fonte do próprio botão.
     */
    public const GLYPH_SIZES = [
        'sm' => 'text-[12px]',
        'md' => 'text-[14px]',
        'lg' => 'text-[18px]',
    ];

    /**
     * Cria uma nova instância do componente de botão.
     */
    public function __construct(
        public string $style = 'solid',
        public string $color = 'primary',
        public string $size = 'md',
        public bool $block = false,
        public bool $loading = false,
        public string $icon = '',
        public string $iconPosition = 'left',
        public bool $iconOnly = false,
        public string $colorToken = '',
    ) {
        $this->color = $this->validateVariant($color, [...self::COLORS, self::CUSTOM_COLOR], 'primary', 'color');

        if ($this->color === self::CUSTOM_COLOR && preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $this->colorToken) !== 1) {
            $this->reportInvalid(sprintf(
                'Button: color="custom" exige color-token com o nome de um token CSS (ex.: brand-blue); recebido "%s".',
                $this->colorToken,
            ));

            $this->color = 'primary';
        }
    }

    /**
     * Retorna as classes de tamanho para o botão.
     */
    public function sizeClasses(): string
    {
        $isRounded = in_array($this->style, ['rounded', 'outline-rounded', 'soft-rounded']);

        if ($this->iconOnly) {
            return match ($this->size) {
                'sm' => $isRounded ? 'w-8 h-8 shrink-0 text-xs' : 'w-8 h-8 shrink-0 text-xs rounded-lg',
                'lg' => $isRounded ? 'w-12 h-12 shrink-0 text-lg' : 'w-12 h-12 shrink-0 text-lg rounded-xl',
                default => $isRounded ? 'w-11 h-11 shrink-0 text-sm' : 'w-11 h-11 shrink-0 text-sm rounded-xl',
            };
        }

        return match ($this->size) {
            'sm' => $isRounded ? 'px-3 py-1.5 text-xs' : 'px-3 py-1.5 text-xs rounded-lg',
            'lg' => $isRounded ? 'px-8 py-4 text-lg font-headline' : 'px-8 py-4 text-lg rounded-xl font-headline',
            default => $isRounded ? 'px-5 py-2.5 text-sm' : 'px-5 py-2.5 text-sm rounded-xl',
        };
    }

    /**
     * Classes FA do glifo (CT-01): `fa-<estilo> fa-<nome>` com o `icon` em `[estilo:]nome`
     * (CT-03) e a classe de tamanho do `size` do botão, sem `style` inline.
     *
     * @throws InvalidArgumentException
     */
    public function iconClasses(): string
    {
        ['style' => $style, 'name' => $name] = FontAwesome::parse($this->icon);

        return "fa-{$style} fa-{$name} ".(self::GLYPH_SIZES[$this->size] ?? self::GLYPH_SIZES['md']);
    }

    /**
     * Mapa de classes por cor — todas as classes são literais para que o
     * Tailwind v4 as detecte durante o scan dos arquivos fonte.
     */
    private const COLOR_CLASSES = [
        'primary' => [
            'solid' => 'bg-primary text-white hover:opacity-90',
            'rounded' => 'bg-primary text-white rounded-full hover:opacity-90',
            'outline' => 'border-2 border-primary text-primary bg-transparent hover:bg-primary/5',
            'outline-rounded' => 'border-2 border-primary text-primary bg-transparent rounded-full hover:bg-primary/5',
            'soft' => 'bg-primary/10 text-primary hover:bg-primary/20',
            'soft-rounded' => 'bg-primary/10 text-primary rounded-full hover:bg-primary/20',
        ],
        'secondary' => [
            'solid' => 'bg-secondary text-white hover:opacity-90',
            'rounded' => 'bg-secondary text-white rounded-full hover:opacity-90',
            'outline' => 'border-2 border-secondary text-secondary bg-transparent hover:bg-secondary/5',
            'outline-rounded' => 'border-2 border-secondary text-secondary bg-transparent rounded-full hover:bg-secondary/5',
            'soft' => 'bg-secondary/10 text-secondary hover:bg-secondary/20',
            'soft-rounded' => 'bg-secondary/10 text-secondary rounded-full hover:bg-secondary/20',
        ],
        'success' => [
            'solid' => 'bg-success text-white hover:opacity-90',
            'rounded' => 'bg-success text-white rounded-full hover:opacity-90',
            'outline' => 'border-2 border-success text-success bg-transparent hover:bg-success/5',
            'outline-rounded' => 'border-2 border-success text-success bg-transparent rounded-full hover:bg-success/5',
            'soft' => 'bg-success/10 text-success hover:bg-success/20',
            'soft-rounded' => 'bg-success/10 text-success rounded-full hover:bg-success/20',
        ],
        'info' => [
            'solid' => 'bg-secondary-container text-white hover:opacity-90',
            'rounded' => 'bg-secondary-container text-white rounded-full hover:opacity-90',
            'outline' => 'border-2 border-info text-info bg-transparent hover:bg-info/5',
            'outline-rounded' => 'border-2 border-info text-info bg-transparent rounded-full hover:bg-info/5',
            'soft' => 'bg-info/10 text-info hover:bg-info/20',
            'soft-rounded' => 'bg-info/10 text-info rounded-full hover:bg-info/20',
        ],
        'warning' => [
            'solid' => 'bg-warning-solid text-white hover:opacity-90',
            'rounded' => 'bg-warning-solid text-white rounded-full hover:opacity-90',
            'outline' => 'border-2 border-warning text-warning bg-transparent hover:bg-warning/5',
            'outline-rounded' => 'border-2 border-warning text-warning bg-transparent rounded-full hover:bg-warning/5',
            'soft' => 'bg-warning/10 text-warning hover:bg-warning/20',
            'soft-rounded' => 'bg-warning/10 text-warning rounded-full hover:bg-warning/20',
        ],
        'danger' => [
            'solid' => 'bg-danger-solid text-white hover:opacity-90',
            'rounded' => 'bg-danger-solid text-white rounded-full hover:opacity-90',
            'outline' => 'border-2 border-error text-error bg-transparent hover:bg-error/5',
            'outline-rounded' => 'border-2 border-error text-error bg-transparent rounded-full hover:bg-error/5',
            'soft' => 'bg-error/10 text-error hover:bg-error/20',
            'soft-rounded' => 'bg-error/10 text-error rounded-full hover:bg-error/20',
        ],
        'dark' => [
            'solid' => 'bg-on-surface text-surface hover:opacity-90',
            'rounded' => 'bg-on-surface text-surface rounded-full hover:opacity-90',
            'outline' => 'border-2 border-on-surface text-on-surface bg-transparent hover:bg-on-surface/5',
            'outline-rounded' => 'border-2 border-on-surface text-on-surface bg-transparent rounded-full hover:bg-on-surface/5',
            'soft' => 'bg-on-surface/10 text-on-surface hover:bg-on-surface/20',
            'soft-rounded' => 'bg-on-surface/10 text-on-surface rounded-full hover:bg-on-surface/20',
        ],
        'light' => [
            'solid' => 'bg-surface-container-high text-on-surface rounded-xl hover:bg-surface-container-highest',
            'rounded' => 'bg-surface-container-high text-on-surface rounded-full hover:bg-surface-container-highest',
            'outline' => 'border-2 border-outline-variant text-on-surface-variant bg-transparent rounded-xl hover:bg-surface-container-low',
            'outline-rounded' => 'border-2 border-outline-variant text-on-surface-variant bg-transparent rounded-full hover:bg-surface-container-low',
            'soft' => 'bg-surface-container-high text-on-surface rounded-xl hover:bg-surface-container-highest',
            'soft-rounded' => 'bg-surface-container-high text-on-surface rounded-full hover:bg-surface-container-highest',
        ],
    ];

    /**
     * Retorna as classes de estilo e cor para o botão no estado normal.
     */
    public function styleClasses(): string
    {
        if ($this->color === self::CUSTOM_COLOR) {
            return $this->customStyleClasses();
        }

        $color = $this->color;
        $style = $this->style;

        return self::COLOR_CLASSES[$color][$style]
            ?? self::COLOR_CLASSES[$color]['solid']
            ?? self::COLOR_CLASSES['primary'][$style]
            ?? self::COLOR_CLASSES['primary']['solid'];
    }

    /**
     * Classes da cor `custom`, montadas sobre `var(--color-<token>)`.
     *
     * O nome da classe depende do token, então o scan do Tailwind da aplicação só a gera se
     * ela aparecer literal em algum arquivo; `customStyle()` garante o fundo de qualquer forma.
     */
    public function customStyleClasses(): string
    {
        $value = 'var(--color-'.$this->colorToken.')';
        $isRounded = in_array($this->style, ['rounded', 'outline-rounded', 'soft-rounded']) ? ' rounded-full' : '';

        return match (true) {
            str_starts_with($this->style, 'outline') => "border-2 border-[{$value}] text-[{$value}] bg-transparent hover:opacity-80{$isRounded}",
            str_starts_with($this->style, 'soft') => "bg-[{$value}]/10 text-[{$value}] hover:bg-[{$value}]/20{$isRounded}",
            default => "bg-[{$value}] text-white hover:opacity-90{$isRounded}",
        };
    }

    /**
     * Estilo inline da cor `custom` nos estilos sólidos: o fundo não pode depender do scan
     * do Tailwind, senão o texto branco fica sobre fundo transparente.
     */
    public function customStyle(): string
    {
        if ($this->color !== self::CUSTOM_COLOR || ! in_array($this->style, ['solid', 'rounded'], true)) {
            return '';
        }

        return 'background-color: var(--color-'.$this->colorToken.')';
    }

    /**
     * Exige nome acessível no botão só de ícone: sem texto no slot, `aria-label` ou `title`
     * é obrigatório. Lança em `local`/`testing` e registra `Log::warning` nos demais.
     *
     * @throws InvalidArgumentException
     */
    public function assertAccessibleName(bool $hasSlotText, bool $hasAriaLabel, bool $hasTitle): void
    {
        if (! $this->iconOnly || $hasSlotText || $hasAriaLabel || $hasTitle) {
            return;
        }

        $this->reportInvalid('Button: icon-only sem texto no slot exige aria-label ou title.');
    }

    /**
     * Lança em `local`/`testing`; nos demais ambientes registra `Log::warning`.
     *
     * @throws InvalidArgumentException
     */
    private function reportInvalid(string $message): void
    {
        if (in_array(config('app.env'), ['local', 'testing'], true)) {
            throw new InvalidArgumentException($message);
        }

        Log::warning($message, ['component' => static::class]);
    }

    /**
     * Retorna as classes de estado desabilitado para o botão.
     */
    public function disabledClasses(): string
    {
        return match (true) {
            in_array($this->style, ['outline', 'outline-rounded']) => 'border-2 border-outline-variant/30 text-outline-variant/50 bg-transparent cursor-not-allowed',
            in_array($this->style, ['soft', 'soft-rounded']) => 'bg-surface-container-low text-outline-variant/50 cursor-not-allowed',
            default => 'bg-primary/40 text-white/70 cursor-not-allowed',
        };
    }

    /**
     * Indica se o botão está desabilitado (loading ou atributo disabled).
     */
    public function isDisabled(): bool
    {
        return $this->loading;
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.button');
    }
}
