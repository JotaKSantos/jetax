@php
    $editorId = 'editor_'.uniqid();
    $wireModel = $attributes->whereStartsWith('wire:model')->first();
    $initialContent = $initialContent((string) $slot);
    $editorKey = (string) ($attributes->get('data-editor-key') ?? $editorId);
    $locked = $isLocked();
@endphp

<div
    data-editor-container
    data-editor-key="{{ $editorKey }}"
    @if($readonly) data-editor-readonly aria-readonly="true" @endif
    x-data="{
        content: {{ $wireModel ? '$wire.get('.Js::from($wireModel).') ?? ' : '' }}{{ Js::from($initialContent) }},
        editorId: {{ Js::from($editorId) }},
        editorKey: {{ Js::from($editorKey) }},
        wireModel: {{ Js::from($wireModel) }},
        disabled: {{ $locked ? 'true' : 'false' }},
        savedRange: null,
        linkOpen: false,
        linkUrl: '',

        init() {
            // Hidratação inicial: o valor do servidor (ou de `value`) entra na área editável.
            this.hydrate(this.content);

            // Reidratação: quando `content` muda por fora da área editável, ela é reescrita.
            this.$watch('content', (value) => {
                if (this.$refs.content && value !== this.$refs.content.innerHTML) {
                    this.hydrate(value);
                }
            });

            // Com `wire:model`, a mudança da propriedade no servidor volta para `content`.
            if (this.wireModel && typeof this.$wire !== 'undefined' && typeof this.$wire.$watch === 'function') {
                this.$wire.$watch(this.wireModel, (value) => {
                    if ((value ?? '') !== this.content) {
                        this.content = value ?? '';
                    }
                });
            }
        },

        hydrate(value) {
            if (! this.$refs.content) return;
            this.$refs.content.innerHTML = value ?? '';
        },

        // A seleção é salva a cada interação: clicar fora da área editável (chip de
        // variável, campo de link) apaga a seleção do documento.
        saveSelection() {
            const selection = window.getSelection();
            if (! selection || selection.rangeCount === 0) return;

            const range = selection.getRangeAt(0);
            if (this.$refs.content && this.$refs.content.contains(range.commonAncestorContainer)) {
                this.savedRange = range.cloneRange();
            }
        },

        restoreSelection() {
            if (! this.$refs.content) return;
            this.$refs.content.focus();

            const selection = window.getSelection();
            if (! selection) return;

            if (this.savedRange) {
                selection.removeAllRanges();
                selection.addRange(this.savedRange);
                return;
            }

            // Sem seleção salva, o cursor vai para o fim do conteúdo.
            const range = document.createRange();
            range.selectNodeContents(this.$refs.content);
            range.collapse(false);
            selection.removeAllRanges();
            selection.addRange(range);
        },

        insertAtCursor(text) {
            if (this.disabled) return;

            this.restoreSelection();
            document.execCommand('insertText', false, text);
            this.saveSelection();
            this.syncContent();
        },

        execCommand(command) {
            if (this.disabled) return;
            document.execCommand(command, false, null);
            this.$refs.content.focus();
            this.syncContent();
        },

        insertOrderedList() {
            this.execCommand('insertOrderedList');
        },

        insertUnorderedList() {
            this.execCommand('insertUnorderedList');
        },

        // O link é pedido num campo inline do próprio editor, nunca em diálogo nativo.
        openLink() {
            if (this.disabled) return;
            this.saveSelection();
            this.linkUrl = '';
            this.linkOpen = true;
            this.$nextTick(() => this.$refs.linkInput && this.$refs.linkInput.focus());
        },

        applyLink() {
            const url = this.linkUrl.trim();
            this.linkOpen = false;
            this.linkUrl = '';
            if (this.disabled || url === '') return;

            this.restoreSelection();
            document.execCommand('createLink', false, url);
            this.saveSelection();
            this.syncContent();
        },

        cancelLink() {
            this.linkOpen = false;
            this.linkUrl = '';
            this.restoreSelection();
        },

        undo() {
            this.execCommand('undo');
        },

        redo() {
            this.execCommand('redo');
        },

        syncContent() {
            this.content = this.$refs.content.innerHTML;

            // A ordem é o contrato: o `x-model` do input oculto devolve `value` para
            // `content` ao ouvir `input`. Escrever o `value` antes de disparar o evento
            // torna essa devolução idempotente; ao contrário, o valor antigo sobrescreve
            // o que acabou de ser sincronizado.
            this.$refs.hiddenInput.value = this.content;
            this.$refs.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
        },
    }"
    @editor-insert.window="if ($event.detail.editor === editorKey) { insertAtCursor($event.detail.text) }"
    {{ $attributes->only('class')->merge(['class' => 'rounded-lg overflow-hidden bg-surface-container-low'.($disabled ? ' opacity-50 cursor-not-allowed' : '')]) }}
>
    {{-- Toolbar --}}
    <div
        data-editor-toolbar
        class="flex items-center gap-0.5 px-2 py-1.5 border-b border-outline-variant bg-surface-container-low"
    >
        {{-- Bold --}}
        <button
            type="button"
            data-action="bold"
            @click="execCommand('bold')"
            :disabled="disabled"
            title="Negrito"
            class="{{ $toolbarButtonClasses() }}"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/>
                <path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/>
            </svg>
        </button>

        {{-- Italic --}}
        <button
            type="button"
            data-action="italic"
            @click="execCommand('italic')"
            :disabled="disabled"
            title="Itálico"
            class="{{ $toolbarButtonClasses() }}"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="4" x2="10" y2="4"/>
                <line x1="14" y1="20" x2="5" y2="20"/>
                <line x1="15" y1="4" x2="9" y2="20"/>
            </svg>
        </button>

        {{-- Underline --}}
        <button
            type="button"
            data-action="underline"
            @click="execCommand('underline')"
            :disabled="disabled"
            title="Sublinhado"
            class="{{ $toolbarButtonClasses() }}"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"/>
                <line x1="4" y1="21" x2="20" y2="21"/>
            </svg>
        </button>

        <div class="w-px h-4 bg-outline-variant mx-1"></div>

        {{-- Lista ordenada --}}
        <button
            type="button"
            data-action="orderedList"
            @click="insertOrderedList()"
            :disabled="disabled"
            title="Lista ordenada"
            class="{{ $toolbarButtonClasses() }}"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="10" y1="6" x2="21" y2="6"/>
                <line x1="10" y1="12" x2="21" y2="12"/>
                <line x1="10" y1="18" x2="21" y2="18"/>
                <path d="M4 6h1v4"/>
                <path d="M4 10h2"/>
                <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/>
            </svg>
        </button>

        {{-- Lista não-ordenada --}}
        <button
            type="button"
            data-action="unorderedList"
            @click="insertUnorderedList()"
            :disabled="disabled"
            title="Lista não-ordenada"
            class="{{ $toolbarButtonClasses() }}"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="8" y1="6" x2="21" y2="6"/>
                <line x1="8" y1="12" x2="21" y2="12"/>
                <line x1="8" y1="18" x2="21" y2="18"/>
                <line x1="3" y1="6" x2="3.01" y2="6"/>
                <line x1="3" y1="12" x2="3.01" y2="12"/>
                <line x1="3" y1="18" x2="3.01" y2="18"/>
            </svg>
        </button>

        @unless($withoutLink)
            <div class="w-px h-4 bg-outline-variant mx-1"></div>

            {{-- Link --}}
            <button
                type="button"
                data-action="link"
                @click="openLink()"
                :disabled="disabled"
                title="Inserir link"
                class="{{ $toolbarButtonClasses() }}"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                </svg>
            </button>
        @endunless

        <div class="w-px h-4 bg-outline-variant mx-1"></div>

        {{-- Desfazer --}}
        <button
            type="button"
            data-action="undo"
            @click="undo()"
            :disabled="disabled"
            title="Desfazer"
            class="{{ $toolbarButtonClasses() }}"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 7v6h6"/>
                <path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/>
            </svg>
        </button>

        {{-- Refazer --}}
        <button
            type="button"
            data-action="redo"
            @click="redo()"
            :disabled="disabled"
            title="Refazer"
            class="{{ $toolbarButtonClasses() }}"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 7v6h-6"/>
                <path d="M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3L21 13"/>
            </svg>
        </button>
    </div>

    @unless($withoutLink)
        {{-- Campo inline do link (substitui o diálogo nativo) --}}
        <div
            data-editor-link-field
            x-show="linkOpen"
            x-cloak
            class="flex items-center gap-2 px-2 py-1.5 border-b border-outline-variant bg-surface-container-low"
        >
            <x-jetax-icon name="link" size="sm" class="text-on-surface-variant" />
            <input
                x-ref="linkInput"
                type="url"
                x-model="linkUrl"
                @keydown.enter.prevent="applyLink()"
                @keydown.escape.prevent="cancelLink()"
                placeholder="https://"
                aria-label="URL do link"
                class="flex-1 min-w-0 h-8 px-2 rounded border border-outline-variant bg-surface-container-lowest text-sm text-on-surface focus:outline-none focus:border-primary"
            />
            <button
                type="button"
                data-editor-link-apply
                @click="applyLink()"
                class="px-2 h-8 rounded text-xs font-semibold text-primary hover:bg-surface-container-high transition-colors"
            >Aplicar</button>
            <button
                type="button"
                data-editor-link-cancel
                @click="cancelLink()"
                class="px-2 h-8 rounded text-xs font-semibold text-on-surface-variant hover:bg-surface-container-high transition-colors"
            >Cancelar</button>
        </div>
    @endunless

    {{-- Área de conteúdo editável --}}
    <div
        x-ref="content"
        data-editor-content
        contenteditable="{{ $locked ? 'false' : 'true' }}"
        @input="syncContent()"
        @keyup="saveSelection(); syncContent()"
        @mouseup="saveSelection()"
        @blur="saveSelection()"
        style="min-height: {{ $height }};"
        class="px-4 py-3 text-sm text-on-surface outline-none focus:outline-none bg-surface-container-low {{ $locked ? 'cursor-not-allowed' : '' }}"
        @if($placeholder)
            data-placeholder="{{ $placeholder }}"
            x-bind:class="content === '' ? 'empty' : ''"
        @endif
    ></div>

    {{-- Input oculto para sincronização via wire:model --}}
    <input
        x-ref="hiddenInput"
        type="hidden"
        id="{{ $editorId }}"
        x-model="content"
        {{ $attributes->whereStartsWith('wire:model') }}
        {{ $attributes->whereStartsWith('name') }}
    />
</div>
