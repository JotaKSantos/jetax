<div
    x-data="{
        tags: [],
        inputValue: '',
        suggestions: {{ json_encode($suggestions) }},
        max: {{ $max ?? 'null' }},
        disabled: {{ $disabled ? 'true' : 'false' }},
        get filteredSuggestions() {
            if (!this.inputValue.trim()) return [];
            const val = this.inputValue.toLowerCase();
            return this.suggestions.filter(s =>
                s.toLowerCase().includes(val) && !this.tags.includes(s)
            );
        },
        addTag(value) {
            if (this.disabled) return;
            const tag = value.trim().replace(/,$/, '');
            if (!tag) return;
            if (this.max !== null && this.tags.length >= this.max) return;
            if (this.tags.includes(tag)) {
                this.inputValue = '';
                return;
            }
            this.tags.push(tag);
            this.inputValue = '';
        },
        removeTag(index) {
            if (this.disabled) return;
            this.tags.splice(index, 1);
        },
        handleKeydown(event) {
            if (event.key === 'Enter' || event.key === ',') {
                event.preventDefault();
                this.addTag(this.inputValue);
            } else if (event.key === 'Backspace' && !this.inputValue && this.tags.length > 0) {
                this.removeTag(this.tags.length - 1);
            }
        }
    }"
    class="w-full"
>
    {{-- Campo oculto sincronizado com wire:model --}}
    <input
        type="hidden"
        :value="JSON.stringify(tags)"
        {{ $attributes->whereStartsWith('wire:model') }}
    />

    {{-- Container de tags e campo de digitação --}}
    <div
        class="flex flex-wrap items-center gap-1.5 min-h-[42px] w-full rounded-lg px-3 py-2 bg-[#f3f3ff] border border-[#e2e6f1] transition-all focus-within:bg-white focus-within:border-[#0061a5] focus-within:shadow-[0_0_0_2px_rgba(0,97,165,0.1)]"
        :class="disabled ? 'opacity-60 cursor-not-allowed bg-slate-100 border-slate-200' : ''"
    >
        {{-- Tags adicionadas --}}
        <template x-for="(tag, index) in tags" :key="index">
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                <span x-text="tag"></span>
                <button
                    type="button"
                    @click="removeTag(index)"
                    :disabled="disabled"
                    class="inline-flex items-center justify-center w-3.5 h-3.5 rounded-full hover:bg-primary/20 transition-colors disabled:pointer-events-none"
                    aria-label="Remover tag"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-2.5 h-2.5">
                        <path d="M18 6 6 18M6 6l12 12"/>
                    </svg>
                </button>
            </span>
        </template>

        {{-- Campo de digitação --}}
        <input
            type="text"
            x-model="inputValue"
            @keydown="handleKeydown($event)"
            @input="inputValue = $event.target.value"
            :disabled="disabled"
            placeholder="{{ $disabled ? '' : 'Adicionar tag...' }}"
            class="flex-1 min-w-[120px] bg-transparent text-sm text-[#3d3d4e] outline-none placeholder:text-slate-400 disabled:cursor-not-allowed"
            autocomplete="off"
        />
    </div>

    {{-- Sugestões de autocomplete --}}
    <div
        x-show="filteredSuggestions.length > 0 && !disabled"
        x-cloak
        class="relative"
    >
        <ul class="absolute z-50 mt-1 w-full rounded-lg border border-outline-variant bg-surface-container-high shadow-lg py-1 max-h-48 overflow-y-auto">
            <template x-for="suggestion in filteredSuggestions" :key="suggestion">
                <li>
                    <button
                        type="button"
                        @click="addTag(suggestion)"
                        class="w-full text-left px-3 py-1.5 text-sm text-[#3d3d4e] hover:bg-[#f3f3ff] transition-colors"
                        x-text="suggestion"
                    ></button>
                </li>
            </template>
        </ul>
    </div>
</div>
