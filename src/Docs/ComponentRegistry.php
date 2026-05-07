<?php

namespace Jetax\DesignSystem\Docs;

/**
 * Registro de todos os componentes do Jetax com seus metadados de documentação.
 */
class ComponentRegistry
{
    /**
     * Retorna todos os componentes registrados, organizados por categoria.
     *
     * @return array<string, array<int, array<string, mixed>>>
     */
    public static function all(): array
    {
        $components = self::components();

        $grouped = [];
        foreach ($components as $component) {
            $category = $component['category'];
            if (! isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $component;
        }

        return $grouped;
    }

    /**
     * Busca um componente pelo slug.
     *
     * @return array<string, mixed>|null
     */
    public static function find(string $slug): ?array
    {
        foreach (self::components() as $component) {
            if ($component['slug'] === $slug) {
                return $component;
            }
        }

        return null;
    }

    /**
     * Lista todos os slugs disponíveis.
     *
     * @return array<int, string>
     */
    public static function slugs(): array
    {
        return array_column(self::components(), 'slug');
    }

    /**
     * Retorna mapa de ícones Material Symbols por slug de componente.
     *
     * @return array<string, string>
     */
    public static function componentIcons(): array
    {
        return [
            // Botões
            'button'         => 'smart_button',
            // Exibição
            'avatar'         => 'account_circle',
            'badge'          => 'label',
            'spinner'        => 'progress_activity',
            'skeleton'       => 'view_day',
            'progress'       => 'donut_large',
            'empty-state'    => 'inbox',
            // Formulários
            'input'          => 'text_fields',
            'select'         => 'arrow_drop_down_circle',
            'textarea'       => 'notes',
            'checkbox'       => 'check_box',
            'radio'          => 'radio_button_checked',
            'toggle'         => 'toggle_on',
            'form-group'     => 'list_alt',
            'color'          => 'palette',
            'currency'       => 'attach_money',
            'pin'            => 'pin',
            'range'          => 'linear_scale',
            'tag'            => 'sell',
            'time'           => 'schedule',
            'upload'         => 'cloud_upload',
            'editor'         => 'edit_note',
            // Navegação
            'breadcrumbs'    => 'chevron_right',
            'tabs'           => 'tab',
            'pagination'     => 'last_page',
            'dropdown'       => 'arrow_drop_down',
            // Feedback
            'alert'          => 'warning',
            'toast'          => 'notifications_active',
            // Overlay
            'modal'          => 'open_in_new',
            'offcanvas'      => 'side_navigation',
            'tooltip'        => 'info',
            'popover'        => 'chat_bubble',
            'dialog'         => 'help',
            // Dados
            'table'          => 'table_chart',
            'data-table'     => 'table_rows',
            'card'           => 'crop_portrait',
            'stats-card'     => 'monitoring',
            'list-group'     => 'format_list_bulleted',
            'detail-summary' => 'summarize',
            'activity-feed'  => 'dynamic_feed',
            'timeline'       => 'timeline',
            'accordion'      => 'expand_circle_down',
            'collapse'       => 'unfold_less',
            // Scaffold
            'layout'         => 'dashboard',
            'auth-layout'    => 'lock',
            'sidebar'        => 'side_navigation',
            'topbar'         => 'web_asset',
            'page-header'    => 'title',
            // Utilitários
            'icon'           => 'emoji_symbols',
            'back-to-top'    => 'arrow_upward',
            'carousel'       => 'view_carousel',
            'clipboard'      => 'content_copy',
            'dismissable'    => 'close',
            'rating'         => 'star',
            'step'           => 'format_list_numbered',
        ];
    }

    /**
     * Retorna a lista completa de componentes com seus metadados.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function components(): array
    {
        return [
            // ─── Botões ──────────────────────────────────────────────────────────
            [
                'slug'        => 'button',
                'name'        => 'Button',
                'category'    => 'Botões',
                'description' => 'Botão de ação com suporte a estilos, cores, tamanhos, ícones e estado de carregamento.',
                'tag'         => 'x-jetax-button',
                'props'       => [
                    ['name' => 'style',         'type' => 'string', 'default' => 'solid',   'description' => 'Estilo visual: solid, rounded, outline, outline-rounded, soft, soft-rounded'],
                    ['name' => 'color',         'type' => 'string', 'default' => 'primary', 'description' => 'Cor: primary, secondary, success, info, warning, danger, dark, light'],
                    ['name' => 'size',          'type' => 'string', 'default' => 'md',      'description' => 'Tamanho: sm, md, lg'],
                    ['name' => 'block',         'type' => 'bool',   'default' => 'false',   'description' => 'Ocupa toda a largura disponível'],
                    ['name' => 'loading',       'type' => 'bool',   'default' => 'false',   'description' => 'Exibe spinner e desabilita o botão'],
                    ['name' => 'icon',          'type' => 'string', 'default' => "''",      'description' => 'Nome do ícone Material Symbols'],
                    ['name' => 'icon-position', 'type' => 'string', 'default' => 'left',    'description' => 'Posição do ícone: left, right'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Texto ou conteúdo do botão'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.button',
            ],

            // ─── Exibição ─────────────────────────────────────────────────────────
            [
                'slug'        => 'avatar',
                'name'        => 'Avatar',
                'category'    => 'Exibição',
                'description' => 'Exibe imagem de perfil do usuário ou iniciais como fallback.',
                'tag'         => 'x-jetax-avatar',
                'props'       => [
                    ['name' => 'src',     'type' => 'string', 'default' => 'null',  'description' => 'URL da imagem do avatar'],
                    ['name' => 'name',    'type' => 'string', 'default' => "''",    'description' => 'Nome do usuário (usado para gerar as iniciais)'],
                    ['name' => 'size',    'type' => 'string', 'default' => 'md',    'description' => 'Tamanho: xs, sm, md, lg, xl, xxl'],
                    ['name' => 'rounded', 'type' => 'bool',   'default' => 'true',  'description' => 'Forma circular (true) ou quadrada arredondada (false)'],
                    ['name' => 'status',  'type' => 'string', 'default' => 'null',  'description' => 'Indicador de status: online, offline, blocked'],
                ],
                'slots'   => [],
                'preview_partial' => 'jetax::docs.components.previews.avatar',
            ],
            [
                'slug'        => 'badge',
                'name'        => 'Badge',
                'category'    => 'Exibição',
                'description' => 'Etiqueta de status ou categoria com suporte a múltiplos estilos e tamanhos.',
                'tag'         => 'x-jetax-badge',
                'props'       => [
                    ['name' => 'variant', 'type' => 'string', 'default' => 'neutral', 'description' => 'Variante: success, danger, warning, info, neutral'],
                    ['name' => 'style',   'type' => 'string', 'default' => 'soft',    'description' => 'Estilo: soft, solid, status'],
                    ['name' => 'size',    'type' => 'string', 'default' => 'md',      'description' => 'Tamanho: sm, md'],
                    ['name' => 'square',  'type' => 'bool',   'default' => 'false',   'description' => 'Bordas quadradas (rounded-lg em vez de rounded-full)'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Texto do badge'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.badge',
            ],
            [
                'slug'        => 'spinner',
                'name'        => 'Spinner',
                'category'    => 'Exibição',
                'description' => 'Indicador de carregamento animado.',
                'tag'         => 'x-jetax-spinner',
                'props'       => [
                    ['name' => 'size',  'type' => 'string', 'default' => 'md',      'description' => 'Tamanho: sm, md, lg'],
                    ['name' => 'color', 'type' => 'string', 'default' => 'primary', 'description' => 'Cor do spinner'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.spinner',
            ],
            [
                'slug'        => 'skeleton',
                'name'        => 'Skeleton',
                'category'    => 'Exibição',
                'description' => 'Placeholder animado para indicar carregamento de conteúdo.',
                'tag'         => 'x-jetax-skeleton',
                'props'       => [
                    ['name' => 'width',   'type' => 'string', 'default' => 'full',  'description' => 'Largura: full, 1/2, 1/3, 2/3, 1/4, 3/4, 16, 24, 32, 48, 64'],
                    ['name' => 'height',  'type' => 'string', 'default' => '4',     'description' => 'Altura: 2, 3, 4, 6, 8, 10, 12, 16, 24, 32, 48'],
                    ['name' => 'rounded', 'type' => 'bool',   'default' => 'false', 'description' => 'Bordas totalmente arredondadas (rounded-full)'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.skeleton',
            ],
            [
                'slug'        => 'progress',
                'name'        => 'Progress',
                'category'    => 'Exibição',
                'description' => 'Barra de progresso com suporte a percentual, cor e rótulo.',
                'tag'         => 'x-jetax-progress',
                'props'       => [
                    ['name' => 'value',    'type' => 'int|float', 'default' => '0',       'description' => 'Valor atual (0–100)'],
                    ['name' => 'max',      'type' => 'int|float', 'default' => '100',     'description' => 'Valor máximo'],
                    ['name' => 'color',    'type' => 'string',    'default' => 'primary', 'description' => 'Cor da barra: primary, success, warning, danger'],
                    ['name' => 'size',     'type' => 'string',    'default' => 'md',      'description' => 'Tamanho: sm, md, lg'],
                    ['name' => 'label',    'type' => 'string',    'default' => 'null',    'description' => 'Rótulo exibido acima da barra com percentual'],
                    ['name' => 'animated', 'type' => 'bool',      'default' => 'false',   'description' => 'Padrão listrado animado'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.progress',
            ],
            [
                'slug'        => 'empty-state',
                'name'        => 'Empty State',
                'category'    => 'Exibição',
                'description' => 'Estado vazio para listas e páginas sem conteúdo.',
                'tag'         => 'x-jetax-empty-state',
                'props'       => [
                    ['name' => 'title',       'type' => 'string', 'default' => "''",      'description' => 'Título do estado vazio'],
                    ['name' => 'description', 'type' => 'string', 'default' => "''",      'description' => 'Descrição complementar'],
                    ['name' => 'icon',        'type' => 'string', 'default' => 'inbox',   'description' => 'Ícone Material Symbols'],
                    ['name' => 'type',        'type' => 'string', 'default' => 'empty',   'description' => 'Tipo: empty, no-results'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Botão ou link de ação'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.empty-state',
            ],

            // ─── Formulários ─────────────────────────────────────────────────────
            [
                'slug'        => 'input',
                'name'        => 'Input',
                'category'    => 'Formulários',
                'description' => 'Campo de texto com suporte a ícones, estados de erro, hint e máscara.',
                'tag'         => 'x-jetax-input',
                'props'       => [
                    ['name' => 'label',       'type' => 'string', 'default' => "''",    'description' => 'Rótulo do campo'],
                    ['name' => 'placeholder', 'type' => 'string', 'default' => "''",    'description' => 'Texto de dica'],
                    ['name' => 'hint',        'type' => 'string', 'default' => "''",    'description' => 'Texto de ajuda abaixo do campo'],
                    ['name' => 'error',       'type' => 'string', 'default' => "''",    'description' => 'Mensagem de erro'],
                    ['name' => 'icon',        'type' => 'string', 'default' => "''",    'description' => 'Ícone Material Symbols à esquerda'],
                    ['name' => 'trailing',    'type' => 'string', 'default' => "''",    'description' => 'Ícone ou texto à direita'],
                    ['name' => 'type',        'type' => 'string', 'default' => 'text',  'description' => 'Tipo HTML do input'],
                    ['name' => 'disabled',    'type' => 'bool',   'default' => 'false', 'description' => 'Desabilita o campo'],
                    ['name' => 'required',    'type' => 'bool',   'default' => 'false', 'description' => 'Marca campo como obrigatório'],
                ],
                'slots' => [
                    ['name' => 'prefix',  'description' => 'Conteúdo no prefixo do campo'],
                    ['name' => 'suffix',  'description' => 'Conteúdo no sufixo do campo'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.input',
            ],
            [
                'slug'        => 'select',
                'name'        => 'Select',
                'category'    => 'Formulários',
                'description' => 'Campo de seleção com opções simples ou agrupadas.',
                'tag'         => 'x-jetax-select',
                'props'       => [
                    ['name' => 'label',    'type' => 'string', 'default' => "''",    'description' => 'Rótulo do campo'],
                    ['name' => 'options',  'type' => 'array',  'default' => '[]',    'description' => 'Array de opções [value => label]'],
                    ['name' => 'selected', 'type' => 'mixed',  'default' => 'null',  'description' => 'Valor selecionado'],
                    ['name' => 'hint',     'type' => 'string', 'default' => "''",    'description' => 'Texto de ajuda'],
                    ['name' => 'error',    'type' => 'string', 'default' => "''",    'description' => 'Mensagem de erro'],
                    ['name' => 'disabled', 'type' => 'bool',   'default' => 'false', 'description' => 'Desabilita o campo'],
                ],
                'slots' => [],
                'preview_partial' => 'jetax::docs.components.previews.select',
            ],
            [
                'slug'        => 'textarea',
                'name'        => 'Textarea',
                'category'    => 'Formulários',
                'description' => 'Campo de texto multilinha.',
                'tag'         => 'x-jetax-textarea',
                'props'       => [
                    ['name' => 'label', 'type' => 'string', 'default' => "''",  'description' => 'Rótulo do campo'],
                    ['name' => 'rows',  'type' => 'int',    'default' => '4',   'description' => 'Número de linhas visíveis'],
                    ['name' => 'error', 'type' => 'string', 'default' => "''",  'description' => 'Mensagem de erro'],
                    ['name' => 'hint',  'type' => 'string', 'default' => "''",  'description' => 'Texto de ajuda'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.textarea',
            ],
            [
                'slug'        => 'checkbox',
                'name'        => 'Checkbox',
                'category'    => 'Formulários',
                'description' => 'Caixa de seleção com suporte a estado indeterminado.',
                'tag'         => 'x-jetax-checkbox',
                'props'       => [
                    ['name' => 'label',         'type' => 'string', 'default' => "''",    'description' => 'Rótulo'],
                    ['name' => 'checked',       'type' => 'bool',   'default' => 'false', 'description' => 'Estado marcado'],
                    ['name' => 'indeterminate', 'type' => 'bool',   'default' => 'false', 'description' => 'Estado indeterminado'],
                    ['name' => 'color',         'type' => 'string', 'default' => 'primary','description' => 'Cor do checkbox'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.checkbox',
            ],
            [
                'slug'        => 'radio',
                'name'        => 'Radio',
                'category'    => 'Formulários',
                'description' => 'Botão de rádio para seleção única.',
                'tag'         => 'x-jetax-radio',
                'props'       => [
                    ['name' => 'label', 'type' => 'string', 'default' => "''", 'description' => 'Rótulo'],
                    ['name' => 'name',  'type' => 'string', 'default' => "''", 'description' => 'Nome do grupo de rádio'],
                    ['name' => 'value', 'type' => 'string', 'default' => "''", 'description' => 'Valor do botão'],
                    ['name' => 'color', 'type' => 'string', 'default' => 'primary', 'description' => 'Cor'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.radio',
            ],
            [
                'slug'        => 'toggle',
                'name'        => 'Toggle',
                'category'    => 'Formulários',
                'description' => 'Interruptor ligado/desligado.',
                'tag'         => 'x-jetax-toggle',
                'props'       => [
                    ['name' => 'label',   'type' => 'string', 'default' => "''",    'description' => 'Rótulo'],
                    ['name' => 'checked', 'type' => 'bool',   'default' => 'false', 'description' => 'Estado inicial'],
                    ['name' => 'color',   'type' => 'string', 'default' => 'primary','description' => 'Cor quando ativo'],
                    ['name' => 'size',    'type' => 'string', 'default' => 'md',    'description' => 'Tamanho: sm, md, lg'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.toggle',
            ],
            [
                'slug'        => 'form-group',
                'name'        => 'Form Group',
                'category'    => 'Formulários',
                'description' => 'Agrupa campos de formulário com label e mensagem de erro unificados.',
                'tag'         => 'x-jetax-form-group',
                'props'       => [
                    ['name' => 'label',    'type' => 'string', 'default' => "''", 'description' => 'Rótulo do grupo'],
                    ['name' => 'error',    'type' => 'string', 'default' => "''", 'description' => 'Mensagem de erro'],
                    ['name' => 'hint',     'type' => 'string', 'default' => "''", 'description' => 'Texto de ajuda'],
                    ['name' => 'required', 'type' => 'bool',   'default' => 'false', 'description' => 'Indica campo obrigatório'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Campos do formulário'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.form-group',
            ],
            [
                'slug'        => 'color',
                'name'        => 'Color Picker',
                'category'    => 'Formulários',
                'description' => 'Seletor de cor com painel de opções predefinidas.',
                'tag'         => 'x-jetax-color',
                'props'       => [
                    ['name' => 'label', 'type' => 'string', 'default' => "''",   'description' => 'Rótulo'],
                    ['name' => 'value', 'type' => 'string', 'default' => "''",   'description' => 'Cor selecionada'],
                    ['name' => 'error', 'type' => 'string', 'default' => "''",   'description' => 'Mensagem de erro'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.color',
            ],
            [
                'slug'        => 'currency',
                'name'        => 'Currency',
                'category'    => 'Formulários',
                'description' => 'Campo de entrada formatado para valores monetários.',
                'tag'         => 'x-jetax-currency',
                'props'       => [
                    ['name' => 'label',    'type' => 'string', 'default' => "''",  'description' => 'Rótulo'],
                    ['name' => 'currency', 'type' => 'string', 'default' => 'BRL', 'description' => 'Código da moeda (ISO 4217)'],
                    ['name' => 'locale',   'type' => 'string', 'default' => 'pt-BR','description' => 'Locale para formatação'],
                    ['name' => 'error',    'type' => 'string', 'default' => "''",  'description' => 'Mensagem de erro'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.currency',
            ],
            [
                'slug'        => 'pin',
                'name'        => 'Pin / OTP',
                'category'    => 'Formulários',
                'description' => 'Campo de entrada de PIN ou código OTP com navegação automática entre dígitos.',
                'tag'         => 'x-jetax-pin',
                'props'       => [
                    ['name' => 'length', 'type' => 'int',    'default' => '6',    'description' => 'Número de dígitos'],
                    ['name' => 'label',  'type' => 'string', 'default' => "''",   'description' => 'Rótulo'],
                    ['name' => 'error',  'type' => 'string', 'default' => "''",   'description' => 'Mensagem de erro'],
                    ['name' => 'mask',   'type' => 'bool',   'default' => 'false','description' => 'Oculta os dígitos (modo senha)'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.pin',
            ],
            [
                'slug'        => 'range',
                'name'        => 'Range',
                'category'    => 'Formulários',
                'description' => 'Controle deslizante para seleção de valores numéricos.',
                'tag'         => 'x-jetax-range',
                'props'       => [
                    ['name' => 'label', 'type' => 'string', 'default' => "''",  'description' => 'Rótulo'],
                    ['name' => 'min',   'type' => 'int',    'default' => '0',   'description' => 'Valor mínimo'],
                    ['name' => 'max',   'type' => 'int',    'default' => '100', 'description' => 'Valor máximo'],
                    ['name' => 'step',  'type' => 'int',    'default' => '1',   'description' => 'Incremento'],
                    ['name' => 'value', 'type' => 'int',    'default' => '50',  'description' => 'Valor inicial'],
                    ['name' => 'color', 'type' => 'string', 'default' => 'primary','description' => 'Cor do controle'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.range',
            ],
            [
                'slug'        => 'tag',
                'name'        => 'Tag Input',
                'category'    => 'Formulários',
                'description' => 'Campo de entrada de tags com adição e remoção dinâmica.',
                'tag'         => 'x-jetax-tag',
                'props'       => [
                    ['name' => 'label', 'type' => 'string', 'default' => "''",  'description' => 'Rótulo'],
                    ['name' => 'color', 'type' => 'string', 'default' => 'primary','description' => 'Cor das tags'],
                    ['name' => 'error', 'type' => 'string', 'default' => "''",  'description' => 'Mensagem de erro'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.tag',
            ],
            [
                'slug'        => 'time',
                'name'        => 'Time',
                'category'    => 'Formulários',
                'description' => 'Campo de seleção de horário.',
                'tag'         => 'x-jetax-time',
                'props'       => [
                    ['name' => 'label',  'type' => 'string', 'default' => "''",  'description' => 'Rótulo'],
                    ['name' => 'format', 'type' => 'string', 'default' => '24h', 'description' => 'Formato: 12h ou 24h'],
                    ['name' => 'error',  'type' => 'string', 'default' => "''",  'description' => 'Mensagem de erro'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.time',
            ],
            [
                'slug'        => 'upload',
                'name'        => 'Upload',
                'category'    => 'Formulários',
                'description' => 'Área de upload de arquivos com drag-and-drop e pré-visualização.',
                'tag'         => 'x-jetax-upload',
                'props'       => [
                    ['name' => 'label',    'type' => 'string', 'default' => "''",  'description' => 'Rótulo'],
                    ['name' => 'accept',   'type' => 'string', 'default' => "'*'", 'description' => 'Tipos aceitos (ex: image/*, .pdf)'],
                    ['name' => 'multiple', 'type' => 'bool',   'default' => 'false','description' => 'Permite múltiplos arquivos'],
                    ['name' => 'error',    'type' => 'string', 'default' => "''",  'description' => 'Mensagem de erro'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.upload',
            ],
            [
                'slug'        => 'editor',
                'name'        => 'Editor',
                'category'    => 'Formulários',
                'description' => 'Editor de rich text baseado em Tiptap.',
                'tag'         => 'x-jetax-editor',
                'props'       => [
                    ['name' => 'label', 'type' => 'string', 'default' => "''", 'description' => 'Rótulo'],
                    ['name' => 'error', 'type' => 'string', 'default' => "''", 'description' => 'Mensagem de erro'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.editor',
            ],

            // ─── Navegação ────────────────────────────────────────────────────────
            [
                'slug'        => 'breadcrumbs',
                'name'        => 'Breadcrumbs',
                'category'    => 'Navegação',
                'description' => 'Trilha de navegação hierárquica.',
                'tag'         => 'x-jetax-breadcrumbs',
                'props'       => [
                    ['name' => 'items',     'type' => 'array',  'default' => '[]',         'description' => 'Array de itens [label, url]'],
                    ['name' => 'separator', 'type' => 'string', 'default' => 'chevron_right','description' => 'Ícone separador'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.breadcrumbs',
            ],
            [
                'slug'        => 'tabs',
                'name'        => 'Tabs',
                'category'    => 'Navegação',
                'description' => 'Abas de navegação com conteúdo trocável.',
                'tag'         => 'x-jetax-tabs',
                'props'       => [
                    ['name' => 'tabs',    'type' => 'array',  'default' => '[]',     'description' => 'Array de abas [id, label, icon?]'],
                    ['name' => 'active',  'type' => 'string', 'default' => "''",     'description' => 'ID da aba ativa'],
                    ['name' => 'variant', 'type' => 'string', 'default' => 'pills',  'description' => 'Variante: pills, underline, bordered'],
                ],
                'slots' => [
                    ['name' => 'tab-{id}', 'description' => 'Conteúdo de cada aba'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.tabs',
            ],
            [
                'slug'        => 'pagination',
                'name'        => 'Pagination',
                'category'    => 'Navegação',
                'description' => 'Paginação de resultados com navegação por páginas.',
                'tag'         => 'x-jetax-pagination',
                'props'       => [
                    ['name' => 'currentPage', 'type' => 'int', 'default' => '1',  'description' => 'Página atual'],
                    ['name' => 'lastPage',    'type' => 'int', 'default' => '1',  'description' => 'Última página'],
                    ['name' => 'total',       'type' => 'int', 'default' => '0',  'description' => 'Total de registros'],
                    ['name' => 'perPage',     'type' => 'int', 'default' => '15', 'description' => 'Registros por página'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.pagination',
            ],
            [
                'slug'        => 'dropdown',
                'name'        => 'Dropdown',
                'category'    => 'Navegação',
                'description' => 'Menu suspenso com itens de ação.',
                'tag'         => 'x-jetax-dropdown',
                'props'       => [
                    ['name' => 'label',    'type' => 'string', 'default' => "''",     'description' => 'Texto do gatilho'],
                    ['name' => 'align',    'type' => 'string', 'default' => 'left',   'description' => 'Alinhamento: left, right'],
                    ['name' => 'position', 'type' => 'string', 'default' => 'bottom', 'description' => 'Posição: bottom, top'],
                ],
                'slots' => [
                    ['name' => 'trigger', 'description' => 'Elemento que abre o dropdown'],
                    ['name' => 'default', 'description' => 'Itens do menu (x-jetax-dropdown-item)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.dropdown',
            ],

            // ─── Feedback ─────────────────────────────────────────────────────────
            [
                'slug'        => 'alert',
                'name'        => 'Alert',
                'category'    => 'Feedback',
                'description' => 'Mensagem de alerta contextual com variantes e estilos visuais.',
                'tag'         => 'x-jetax-alert',
                'props'       => [
                    ['name' => 'message',    'type' => 'string', 'default' => 'null',    'description' => 'Mensagem do alerta'],
                    ['name' => 'variant',    'type' => 'string', 'default' => 'primary', 'description' => 'Variante: primary, info, success, warning, danger'],
                    ['name' => 'style',      'type' => 'string', 'default' => 'soft',    'description' => 'Estilo: soft, solid, rich'],
                    ['name' => 'dismissible','type' => 'bool',   'default' => 'false',   'description' => 'Permite fechar o alerta'],
                    ['name' => 'title',      'type' => 'string', 'default' => 'null',    'description' => 'Título opcional'],
                    ['name' => 'icon',       'type' => 'string', 'default' => "''",      'description' => 'Ícone Material Symbols'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Conteúdo customizado (substitui message)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.alert',
            ],
            [
                'slug'        => 'toast',
                'name'        => 'Toast',
                'category'    => 'Feedback',
                'description' => 'Notificações temporárias exibidas via Livewire dispatch.',
                'tag'         => 'x-jetax-toast-container',
                'props'       => [
                    ['name' => 'position', 'type' => 'string', 'default' => 'top-right', 'description' => 'Posição: top-right, top-left, bottom-right, bottom-left'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.toast',
            ],

            // ─── Overlay ──────────────────────────────────────────────────────────
            [
                'slug'            => 'modal',
                'name'            => 'Modal',
                'category'        => 'Overlay',
                'description'     => 'Janela modal com suporte a tamanhos, footer e fechamento.',
                'tag'             => 'x-jetax-modal',
                'preview_partial' => 'jetax::docs.components.previews.modal',
                'props'           => [
                    ['name' => 'id',       'type' => 'string', 'default' => 'modal', 'description' => 'Identificador único do modal'],
                    ['name' => 'size',     'type' => 'string', 'default' => 'md',    'description' => 'Tamanho: sm, md, lg, fullscreen'],
                    ['name' => 'highRisk', 'type' => 'bool',   'default' => 'false', 'description' => 'Estilo visual para ações perigosas'],
                ],
                'slots' => [
                    ['name' => 'header',  'description' => 'Título/cabeçalho do modal'],
                    ['name' => 'default', 'description' => 'Conteúdo do corpo do modal'],
                    ['name' => 'footer',  'description' => 'Botões de ação no rodapé'],
                ],
            ],
            [
                'slug'            => 'offcanvas',
                'name'            => 'Offcanvas',
                'category'        => 'Overlay',
                'description'     => 'Painel lateral deslizante para conteúdo auxiliar ou filtros.',
                'tag'             => 'x-jetax-offcanvas',
                'preview_partial' => 'jetax::docs.components.previews.offcanvas',
                'props'           => [
                    ['name' => 'id',       'type' => 'string', 'default' => 'offcanvas', 'description' => 'Identificador único'],
                    ['name' => 'position', 'type' => 'string', 'default' => 'right',     'description' => 'Posição: left, right, top, bottom'],
                ],
                'slots' => [
                    ['name' => 'header',  'description' => 'Título/cabeçalho do painel'],
                    ['name' => 'default', 'description' => 'Conteúdo do painel'],
                    ['name' => 'footer',  'description' => 'Rodapé do painel'],
                ],
            ],
            [
                'slug'            => 'tooltip',
                'name'            => 'Tooltip',
                'category'        => 'Overlay',
                'description'     => 'Dica de contexto exibida ao passar o mouse.',
                'tag'             => 'x-jetax-tooltip',
                'preview_partial' => 'jetax::docs.components.previews.tooltip',
                'props'           => [
                    ['name' => 'content',  'type' => 'string', 'default' => "''",  'description' => 'Texto do tooltip'],
                    ['name' => 'position', 'type' => 'string', 'default' => 'top', 'description' => 'Posição: top, bottom, left, right'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Elemento que recebe o tooltip'],
                ],
            ],
            [
                'slug'            => 'popover',
                'name'            => 'Popover',
                'category'        => 'Overlay',
                'description'     => 'Balão de conteúdo rico ativado por clique.',
                'tag'             => 'x-jetax-popover',
                'preview_partial' => 'jetax::docs.components.previews.popover',
                'props'           => [
                    ['name' => 'position', 'type' => 'string', 'default' => 'bottom', 'description' => 'Posição: top, bottom, left, right'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Elemento gatilho'],
                    ['name' => 'content', 'description' => 'Conteúdo do popover'],
                ],
            ],
            [
                'slug'            => 'dialog',
                'name'            => 'Dialog',
                'category'        => 'Overlay',
                'description'     => 'Dialog de confirmação simples com título, mensagem e botões de ação.',
                'tag'             => 'x-jetax-dialog',
                'preview_partial' => 'jetax::docs.components.previews.dialog',
                'props'           => [
                    ['name' => 'id',           'type' => 'string', 'default' => 'dialog',    'description' => 'Identificador único'],
                    ['name' => 'title',        'type' => 'string', 'default' => "''",        'description' => 'Título do dialog'],
                    ['name' => 'message',      'type' => 'string', 'default' => "''",        'description' => 'Mensagem/descrição'],
                    ['name' => 'confirmLabel', 'type' => 'string', 'default' => 'Confirmar', 'description' => 'Texto do botão de confirmação'],
                    ['name' => 'cancelLabel',  'type' => 'string', 'default' => 'Cancelar',  'description' => 'Texto do botão de cancelamento'],
                    ['name' => 'variant',      'type' => 'string', 'default' => 'danger',    'description' => 'Variante: danger, warning, primary, success'],
                ],
                'slots' => [],
            ],

            // ─── Dados ────────────────────────────────────────────────────────────
            [
                'slug'        => 'table',
                'name'        => 'Table',
                'category'    => 'Dados',
                'description' => 'Tabela de dados responsiva com suporte a ordenação, seleção e ações.',
                'tag'         => 'x-jetax-table',
                'props'       => [
                    ['name' => 'columns',    'type' => 'array',              'default' => '[]',    'description' => 'Definição das colunas [key, label, sortable?]'],
                    ['name' => 'rows',       'type' => 'array',              'default' => '[]',    'description' => 'Dados das linhas (array de arrays associativos)'],
                    ['name' => 'selectable', 'type' => 'bool',               'default' => 'false', 'description' => 'Habilita seleção de linhas com checkbox'],
                    ['name' => 'paginator',  'type' => 'LengthAwarePaginator','default' => 'null',  'description' => 'Paginador Laravel para exibir paginação'],
                ],
                'slots' => [
                    ['name' => 'body',    'description' => 'Conteúdo customizado do tbody (substitui renderização automática)'],
                    ['name' => 'actions', 'description' => 'Ações por linha (modo automático)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.table',
            ],
            [
                'slug'        => 'data-table',
                'name'        => 'Data Table',
                'category'    => 'Dados',
                'description' => 'Datatable Livewire completa — sort, busca, filtros tipados, paginação server-side e bulk actions. Estado persistido na URL.',
                'tag'         => 'livewire:jetax-docs-clientes-table',
                'props'       => [
                    ['name' => 'builder()',          'type' => 'method', 'default' => '—',              'description' => 'Retorna o Builder Eloquent que alimenta a tabela (abstrato).'],
                    ['name' => 'columns()',          'type' => 'method', 'default' => '[]',             'description' => 'Array de Column (Text, Badge, Date, Actions, ...).'],
                    ['name' => 'filters()',          'type' => 'method', 'default' => '[]',             'description' => 'Array de Filter (Select, MultiSelect, Date).'],
                    ['name' => 'bulkActions()',      'type' => 'method', 'default' => '[]',             'description' => 'Array de BulkAction executadas sobre os ids selecionados.'],
                    ['name' => 'searchableColumns()', 'type' => 'method', 'default' => 'auto',          'description' => 'Override opcional — por padrão deriva das colunas com ->searchable().'],
                    ['name' => 'emptyTitle()',       'type' => 'method', 'default' => "'Nenhum...'",   'description' => 'Título do empty state.'],
                    ['name' => 'emptyDescription()', 'type' => 'method', 'default' => "''",            'description' => 'Descrição do empty state.'],
                    ['name' => 'emptyIcon()',        'type' => 'method', 'default' => "'inbox'",       'description' => 'Ícone Material Symbols do empty state.'],
                ],
                'slots'           => [],
                'preview_partial' => 'jetax::docs.components.previews.data-table',
            ],
            [
                'slug'        => 'card',
                'name'        => 'Card',
                'category'    => 'Dados',
                'description' => 'Container de conteúdo com header, body e footer opcionais.',
                'tag'         => 'x-jetax-card',
                'props'       => [
                    ['name' => 'title',    'type' => 'string', 'default' => "''",    'description' => 'Título do card'],
                    ['name' => 'subtitle', 'type' => 'string', 'default' => "''",    'description' => 'Subtítulo'],
                    ['name' => 'padding',  'type' => 'string', 'default' => 'p-6',   'description' => 'Classe de padding'],
                    ['name' => 'shadow',   'type' => 'bool',   'default' => 'true',  'description' => 'Sombra no card'],
                    ['name' => 'hover',    'type' => 'bool',   'default' => 'false', 'description' => 'Efeito de hover'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Conteúdo principal'],
                    ['name' => 'header',  'description' => 'Cabeçalho customizado'],
                    ['name' => 'footer',  'description' => 'Rodapé do card'],
                    ['name' => 'actions', 'description' => 'Ações no cabeçalho'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.card',
            ],
            [
                'slug'        => 'stats-card',
                'name'        => 'Stats Card',
                'category'    => 'Dados',
                'description' => 'Card de estatísticas com valor, variação e ícone.',
                'tag'         => 'x-jetax-stats-card',
                'props'       => [
                    ['name' => 'title',    'type' => 'string', 'default' => "''",  'description' => 'Título da métrica'],
                    ['name' => 'value',    'type' => 'string', 'default' => "''",  'description' => 'Valor principal'],
                    ['name' => 'change',   'type' => 'string', 'default' => "''",  'description' => 'Variação (ex: +12%)'],
                    ['name' => 'trend',    'type' => 'string', 'default' => "''",  'description' => 'Tendência: up, down, neutral'],
                    ['name' => 'icon',     'type' => 'string', 'default' => "''",  'description' => 'Ícone Material Symbols'],
                    ['name' => 'color',    'type' => 'string', 'default' => 'primary','description' => 'Cor do ícone'],
                    ['name' => 'subtitle', 'type' => 'string', 'default' => "''",  'description' => 'Subtítulo/contexto'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.stats-card',
            ],
            [
                'slug'        => 'list-group',
                'name'        => 'List Group',
                'category'    => 'Dados',
                'description' => 'Lista de itens com suporte a ícones, ações e variantes.',
                'tag'         => 'x-jetax-list-group',
                'props'       => [
                    ['name' => 'flush',   'type' => 'bool', 'default' => 'false', 'description' => 'Remove bordas laterais'],
                    ['name' => 'hoverable','type' => 'bool','default' => 'true',  'description' => 'Destaque no hover'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Itens (x-jetax-list-group-item)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.list-group',
            ],
            [
                'slug'        => 'detail-summary',
                'name'        => 'Detail Summary',
                'category'    => 'Dados',
                'description' => 'Grade de detalhes em formato chave-valor.',
                'tag'         => 'x-jetax-detail-summary',
                'props'       => [
                    ['name' => 'items',   'type' => 'array',  'default' => '[]',  'description' => 'Array de itens [label, value]'],
                    ['name' => 'columns', 'type' => 'int',    'default' => '2',   'description' => 'Número de colunas'],
                    ['name' => 'title',   'type' => 'string', 'default' => "''",  'description' => 'Título da seção'],
                ],
                'slots'    => [],
                'preview_partial' => 'jetax::docs.components.previews.detail-summary',
            ],
            [
                'slug'        => 'activity-feed',
                'name'        => 'Activity Feed',
                'category'    => 'Dados',
                'description' => 'Feed de atividades com linha do tempo vertical.',
                'tag'         => 'x-jetax-activity-feed',
                'props'       => [
                    ['name' => 'items', 'type' => 'array', 'default' => '[]', 'description' => 'Array de atividades'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Itens (x-jetax-activity-feed-item)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.activity-feed',
            ],
            [
                'slug'        => 'timeline',
                'name'        => 'Timeline',
                'category'    => 'Dados',
                'description' => 'Linha do tempo de eventos com marcadores customizáveis.',
                'tag'         => 'x-jetax-timeline',
                'props'       => [
                    ['name' => 'horizontal', 'type' => 'bool', 'default' => 'false', 'description' => 'Ativa layout horizontal (padrão: vertical)'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Itens (x-jetax-timeline-item)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.timeline',
            ],
            [
                'slug'        => 'accordion',
                'name'        => 'Accordion',
                'category'    => 'Dados',
                'description' => 'Conteúdo expansível em seções colapsáveis.',
                'tag'         => 'x-jetax-accordion',
                'props'       => [
                    ['name' => 'mode', 'type' => 'string', 'default' => "'single'", 'description' => "Modo de operação: 'single' ou 'multiple'"],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Itens (x-jetax-accordion-item)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.accordion',
            ],
            [
                'slug'        => 'collapse',
                'name'        => 'Collapse',
                'category'    => 'Dados',
                'description' => 'Conteúdo colapsável controlado por Alpine.js.',
                'tag'         => 'x-jetax-collapse',
                'props'       => [
                    ['name' => 'open', 'type' => 'bool', 'default' => 'false', 'description' => 'Estado inicial aberto'],
                ],
                'slots' => [
                    ['name' => 'trigger',  'description' => 'Botão/elemento que controla o collapse'],
                    ['name' => 'default',  'description' => 'Conteúdo colapsável'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.collapse',
            ],

            // ─── Scaffold ─────────────────────────────────────────────────────────
            [
                'slug'        => 'layout',
                'name'        => 'Layout',
                'category'    => 'Scaffold',
                'description' => 'Shell principal da aplicação com sidebar, topbar e área de conteúdo.',
                'tag'         => 'x-jetax-layout',
                'props'       => [
                    ['name' => 'title', 'type' => 'string', 'default' => "''", 'description' => 'Título da página (tag <title>)'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Conteúdo principal da página'],
                    ['name' => 'sidebar', 'description' => 'Conteúdo da sidebar'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.layout',
            ],
            [
                'slug'        => 'auth-layout',
                'name'        => 'Auth Layout',
                'category'    => 'Scaffold',
                'description' => 'Layout para páginas de autenticação (login, registro, recuperação).',
                'tag'         => 'x-jetax-auth-layout',
                'props'       => [
                    ['name' => 'title', 'type' => 'string', 'default' => "''",  'description' => 'Título da página'],
                    ['name' => 'logo',  'type' => 'string', 'default' => "''",  'description' => 'URL do logo'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Formulário de autenticação'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.auth-layout',
            ],
            [
                'slug'        => 'sidebar',
                'name'        => 'Sidebar',
                'category'    => 'Scaffold',
                'description' => 'Navegação lateral com itens, grupos e indicador de item ativo.',
                'tag'         => 'x-jetax-sidebar',
                'props'       => [
                    ['name' => 'collapsed', 'type' => 'bool',   'default' => 'false', 'description' => 'Estado colapsado'],
                    ['name' => 'width',     'type' => 'string', 'default' => 'w-64',  'description' => 'Largura (classe Tailwind)'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Itens de navegação'],
                    ['name' => 'header',  'description' => 'Logo ou nome da aplicação'],
                    ['name' => 'footer',  'description' => 'Perfil do usuário ou ações secundárias'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.sidebar',
            ],
            [
                'slug'        => 'topbar',
                'name'        => 'Topbar',
                'category'    => 'Scaffold',
                'description' => 'Barra superior com busca, notificações e menu do usuário.',
                'tag'         => 'x-jetax-topbar',
                'props'       => [
                    ['name' => 'title', 'type' => 'string', 'default' => "''", 'description' => 'Título exibido na topbar'],
                ],
                'slots' => [
                    ['name' => 'actions', 'description' => 'Ações adicionais à direita'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.topbar',
            ],
            [
                'slug'        => 'page-header',
                'name'        => 'Page Header',
                'category'    => 'Scaffold',
                'description' => 'Cabeçalho de página com título, descrição, breadcrumbs e ações.',
                'tag'         => 'x-jetax-page-header',
                'props'       => [
                    ['name' => 'title',       'type' => 'string', 'default' => "''", 'description' => 'Título da página'],
                    ['name' => 'description', 'type' => 'string', 'default' => "''", 'description' => 'Descrição breve'],
                    ['name' => 'breadcrumbs', 'type' => 'array',  'default' => '[]', 'description' => 'Itens de breadcrumb'],
                ],
                'slots' => [
                    ['name' => 'actions', 'description' => 'Botões de ação'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.page-header',
            ],

            // ─── Utilitários ──────────────────────────────────────────────────────
            [
                'slug'        => 'icon',
                'name'        => 'Icon',
                'category'    => 'Utilitários',
                'description' => 'Ícone Material Symbols Outlined com suporte a tamanho, peso e preenchimento.',
                'tag'         => 'x-jetax-icon',
                'props'       => [
                    ['name' => 'name',   'type' => 'string',    'default' => "''",    'description' => 'Nome do ícone Material Symbols'],
                    ['name' => 'size',   'type' => 'string|int', 'default' => "'md'",  'description' => 'Tamanho: sm, md, lg, xl ou valor numérico em px'],
                    ['name' => 'weight', 'type' => 'int',        'default' => '400',   'description' => 'Peso do ícone (100–700)'],
                    ['name' => 'fill',   'type' => 'bool',       'default' => 'false', 'description' => 'Preenchimento sólido do ícone'],
                ],
                'slots'           => [],
                'preview_partial' => 'jetax::docs.components.previews.icon',
            ],
            [
                'slug'        => 'back-to-top',
                'name'        => 'Back to Top',
                'category'    => 'Utilitários',
                'description' => 'Botão fixo que aparece após rolar a página, permitindo voltar ao topo.',
                'tag'         => 'x-jetax-back-to-top',
                'props'       => [
                    ['name' => 'threshold', 'type' => 'int', 'default' => '300', 'description' => 'Distância de scroll em pixels para exibir o botão'],
                ],
                'slots'           => [],
                'preview_partial' => 'jetax::docs.components.previews.back-to-top',
            ],
            [
                'slug'        => 'carousel',
                'name'        => 'Carousel',
                'category'    => 'Utilitários',
                'description' => 'Carrossel de slides com navegação por setas, indicadores e autoplay.',
                'tag'         => 'x-jetax-carousel',
                'props'       => [
                    ['name' => 'autoplay',   'type' => 'bool',   'default' => 'false',   'description' => 'Inicia reprodução automática dos slides'],
                    ['name' => 'interval',   'type' => 'int',    'default' => '5000',    'description' => 'Intervalo em milissegundos entre slides'],
                    ['name' => 'transition', 'type' => 'string', 'default' => "'slide'", 'description' => 'Tipo de transição: slide ou fade'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Itens do carrossel (x-jetax-carousel-item)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.carousel',
            ],
            [
                'slug'        => 'clipboard',
                'name'        => 'Clipboard',
                'category'    => 'Utilitários',
                'description' => 'Botão para copiar texto para a área de transferência com feedback visual.',
                'tag'         => 'x-jetax-clipboard',
                'props'       => [
                    ['name' => 'text',            'type' => 'string', 'default' => "''", 'description' => 'Texto a ser copiado'],
                    ['name' => 'success-message', 'type' => 'string', 'default' => "''", 'description' => 'Mensagem exibida após copiar'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Trigger customizado (substitui o botão padrão)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.clipboard',
            ],
            [
                'slug'        => 'dismissable',
                'name'        => 'Dismissable',
                'category'    => 'Utilitários',
                'description' => 'Wrapper que permite fechar/ocultar conteúdo com persistência opcional via localStorage.',
                'tag'         => 'x-jetax-dismissable',
                'props'       => [
                    ['name' => 'persist-key', 'type' => 'string', 'default' => 'null', 'description' => 'Chave para persistir estado de fechamento no localStorage'],
                ],
                'slots' => [
                    ['name' => 'default',         'description' => 'Conteúdo que pode ser fechado'],
                    ['name' => 'dismiss-trigger', 'description' => 'Botão de fechar customizado'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.dismissable',
            ],
            [
                'slug'        => 'rating',
                'name'        => 'Rating',
                'category'    => 'Utilitários',
                'description' => 'Avaliação por estrelas interativa com suporte a valores parciais e integração com formulários.',
                'tag'         => 'x-jetax-rating',
                'props'       => [
                    ['name' => 'max',      'type' => 'int',       'default' => '5',     'description' => 'Número máximo de estrelas'],
                    ['name' => 'value',    'type' => 'int|float', 'default' => '0',     'description' => 'Valor inicial/atual'],
                    ['name' => 'size',     'type' => 'string',    'default' => "'md'",  'description' => 'Tamanho: sm, md, lg'],
                    ['name' => 'readonly', 'type' => 'bool',      'default' => 'false', 'description' => 'Modo somente leitura (suporta valores parciais)'],
                    ['name' => 'name',     'type' => 'string',    'default' => "''",    'description' => 'Nome do campo para formulários'],
                ],
                'slots'           => [],
                'preview_partial' => 'jetax::docs.components.previews.rating',
            ],
            [
                'slug'        => 'step',
                'name'        => 'Step',
                'category'    => 'Utilitários',
                'description' => 'Wizard de etapas com estados completo, ativo e pendente, nos layouts horizontal e vertical.',
                'tag'         => 'x-jetax-step',
                'props'       => [
                    ['name' => 'current',   'type' => 'int',  'default' => '1',     'description' => 'Etapa atual (1-indexed)'],
                    ['name' => 'vertical',  'type' => 'bool', 'default' => 'false', 'description' => 'Layout vertical'],
                    ['name' => 'clickable', 'type' => 'bool', 'default' => 'false', 'description' => 'Permite clicar em etapas concluídas para navegar'],
                ],
                'slots' => [
                    ['name' => 'default', 'description' => 'Itens de etapa (x-jetax-step-item)'],
                ],
                'preview_partial' => 'jetax::docs.components.previews.step',
            ],
        ];
    }
}
