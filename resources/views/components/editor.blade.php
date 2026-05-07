@php
    $editorId = 'editor_'.uniqid();
    $wireModel = $attributes->whereStartsWith('wire:model')->first();
@endphp

<div
    data-editor-container
    x-data="{
        content: '',
        editorId: '{{ $editorId }}',
        disabled: {{ $disabled ? 'true' : 'false' }},
        commands: {
            bold: false,
            italic: false,
            underline: false,
            orderedList: false,
            unorderedList: false,
        },

        init() {
            // O TipTap será inicializado aqui quando o JS for carregado no frontend.
            // Este componente fornece a estrutura HTML/Alpine para integração futura.
            if (typeof window.initTiptapEditor === 'function') {
                window.initTiptapEditor(this, this.editorId);
            }
        },

        execCommand(command) {
            if (this.disabled) return;
            document.execCommand(command, false, null);
            this.$refs.content.focus();
            this.syncContent();
        },

        insertOrderedList() {
            if (this.disabled) return;
            document.execCommand('insertOrderedList', false, null);
            this.$refs.content.focus();
            this.syncContent();
        },

        insertUnorderedList() {
            if (this.disabled) return;
            document.execCommand('insertUnorderedList', false, null);
            this.$refs.content.focus();
            this.syncContent();
        },

        insertLink() {
            if (this.disabled) return;
            const url = prompt('Informe a URL do link:');
            if (url) {
                document.execCommand('createLink', false, url);
                this.$refs.content.focus();
                this.syncContent();
            }
        },

        undo() {
            if (this.disabled) return;
            document.execCommand('undo', false, null);
            this.$refs.content.focus();
            this.syncContent();
        },

        redo() {
            if (this.disabled) return;
            document.execCommand('redo', false, null);
            this.$refs.content.focus();
            this.syncContent();
        },

        syncContent() {
            this.content = this.$refs.content.innerHTML;
            this.$refs.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
        },
    }"
    class="rounded-lg overflow-hidden bg-[#f3f3ff] {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
>
    {{-- Toolbar --}}
    <div
        data-editor-toolbar
        class="flex items-center gap-0.5 px-2 py-1.5 border-b border-[#e2e6f1] bg-[#f3f3ff]"
    >
        {{-- Bold --}}
        <button
            type="button"
            data-action="bold"
            @click="execCommand('bold')"
            :disabled="disabled"
            title="Negrito"
            class="p-1.5 rounded text-[#71757e] hover:bg-[#e2e6f1] hover:text-[#1a1f2e] transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
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
            class="p-1.5 rounded text-[#71757e] hover:bg-[#e2e6f1] hover:text-[#1a1f2e] transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
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
            class="p-1.5 rounded text-[#71757e] hover:bg-[#e2e6f1] hover:text-[#1a1f2e] transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"/>
                <line x1="4" y1="21" x2="20" y2="21"/>
            </svg>
        </button>

        <div class="w-px h-4 bg-[#e2e6f1] mx-1"></div>

        {{-- Lista ordenada --}}
        <button
            type="button"
            data-action="orderedList"
            @click="insertOrderedList()"
            :disabled="disabled"
            title="Lista ordenada"
            class="p-1.5 rounded text-[#71757e] hover:bg-[#e2e6f1] hover:text-[#1a1f2e] transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
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
            class="p-1.5 rounded text-[#71757e] hover:bg-[#e2e6f1] hover:text-[#1a1f2e] transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
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

        <div class="w-px h-4 bg-[#e2e6f1] mx-1"></div>

        {{-- Link --}}
        <button
            type="button"
            data-action="link"
            @click="insertLink()"
            :disabled="disabled"
            title="Inserir link"
            class="p-1.5 rounded text-[#71757e] hover:bg-[#e2e6f1] hover:text-[#1a1f2e] transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
            </svg>
        </button>

        <div class="w-px h-4 bg-[#e2e6f1] mx-1"></div>

        {{-- Desfazer --}}
        <button
            type="button"
            data-action="undo"
            @click="undo()"
            :disabled="disabled"
            title="Desfazer"
            class="p-1.5 rounded text-[#71757e] hover:bg-[#e2e6f1] hover:text-[#1a1f2e] transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
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
            class="p-1.5 rounded text-[#71757e] hover:bg-[#e2e6f1] hover:text-[#1a1f2e] transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 7v6h-6"/>
                <path d="M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3L21 13"/>
            </svg>
        </button>
    </div>

    {{-- Área de conteúdo editável --}}
    <div
        x-ref="content"
        data-editor-content
        contenteditable="{{ $disabled ? 'false' : 'true' }}"
        @input="syncContent()"
        @keyup="syncContent()"
        style="min-height: {{ $height }};"
        class="px-4 py-3 text-sm text-[#1a1f2e] outline-none focus:outline-none bg-[#f3f3ff] {{ $disabled ? 'cursor-not-allowed' : '' }}"
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
