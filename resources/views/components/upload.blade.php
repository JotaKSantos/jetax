@php
    $inputId = 'upload_'.uniqid();
    $maxBytes = $maxSizeBytes();
@endphp

<div
    data-dropzone
    x-data="{
        isDragging: false,
        files: [],
        errors: [],
        maxSizeBytes: {{ $maxBytes }},

        handleDrop(event) {
            this.isDragging = false;
            const droppedFiles = Array.from(event.dataTransfer.files);
            this.processFiles(droppedFiles);
        },

        handleChange(event) {
            const selectedFiles = Array.from(event.target.files);
            this.processFiles(selectedFiles);
        },

        acceptTypes: '{{ $accept }}',

        matchesAccept(file) {
            if (!this.acceptTypes) return true;
            const rules = this.acceptTypes.split(',').map(r => r.trim());
            return rules.some(rule => {
                if (rule.startsWith('.')) return file.name.toLowerCase().endsWith(rule.toLowerCase());
                if (rule.endsWith('/*')) return file.type.startsWith(rule.slice(0, -1));
                return file.type === rule;
            });
        },

        processFiles(newFiles) {
            this.errors = [];
            newFiles.forEach(file => {
                if (!this.matchesAccept(file)) {
                    this.errors.push(`O arquivo &quot;${file.name}&quot; não é um formato aceito (${this.acceptTypes}).`);
                    return;
                }
                if (this.maxSizeBytes > 0 && file.size > this.maxSizeBytes) {
                    this.errors.push(`O arquivo &quot;${file.name}&quot; excede o tamanho máximo de {{ $maxSize }}MB.`);
                    return;
                }
                const entry = { name: file.name, size: file.size, progress: 0, preview: null };
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => { entry.preview = e.target.result; };
                    reader.readAsDataURL(file);
                }
                this.files.push(entry);
            });
        },

        openFilePicker() {
            this.$refs.fileInput.click();
        },

        removeFile(index) {
            this.files.splice(index, 1);
        },

        formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }
    }"
    x-on:dragover.prevent="isDragging = true"
    x-on:dragleave.prevent="isDragging = false"
    x-on:drop.prevent="handleDrop($event)"
    class="w-full"
>
    {{-- Área de Drop --}}
    <div
        x-on:click="openFilePicker()"
        :class="isDragging
            ? 'border-primary bg-blue-50'
            : 'border-slate-300 bg-[#f3f3ff] hover:border-primary hover:bg-blue-50'"
        class="relative flex cursor-pointer flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed p-8 transition-all duration-200"
    >
        {{-- Overlay de arraste --}}
        <div
            x-show="isDragging"
            class="pointer-events-none absolute inset-0 z-10 flex items-center justify-center rounded-xl bg-blue-100/60"
        >
            <span class="text-sm font-semibold text-primary">Solte os arquivos aqui</span>
        </div>

        <span class="material-symbols-outlined text-4xl text-slate-400">cloud_upload</span>

        <div class="text-center">
            <p class="text-sm font-semibold text-slate-600">
                Arraste arquivos aqui ou
                <span class="text-primary underline">clique para selecionar</span>
            </p>
            @if($accept)
                <p class="mt-1 text-xs text-slate-400">Formatos aceitos: {{ $accept }}</p>
            @endif
            @if($maxSize > 0)
                <p class="mt-1 text-xs text-slate-400">Tamanho máximo: {{ $maxSize }}MB por arquivo</p>
            @endif
        </div>
    </div>

    {{-- Input file oculto --}}
    <input
        id="{{ $inputId }}"
        type="file"
        x-ref="fileInput"
        x-on:change="handleChange($event)"
        @if($multiple) multiple @endif
        @if($accept) accept="{{ $accept }}" @endif
        class="hidden"
        {{ $attributes->only(['wire:model']) }}
    />

    {{-- Mensagens de erro de tamanho --}}
    <template x-if="errors.length > 0">
        <div class="mt-3 space-y-1">
            <template x-for="(error, i) in errors" :key="i">
                <div class="flex items-center gap-2 rounded-lg bg-red-50 px-3 py-2 text-xs text-red-600">
                    <span class="material-symbols-outlined text-[16px]">error</span>
                    <span x-html="error"></span>
                </div>
            </template>
        </div>
    </template>

    {{-- Lista de arquivos selecionados --}}
    <template x-if="files.length > 0">
        <div class="mt-3 space-y-2">
            <template x-for="(file, index) in files" :key="index">
                <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-3 py-2">
                    {{-- Thumbnail de imagem --}}
                    <template x-if="file.preview">
                        <img
                            :src="file.preview"
                            :alt="file.name"
                            class="h-10 w-10 flex-shrink-0 rounded object-cover"
                        />
                    </template>

                    {{-- Ícone genérico para não-imagens --}}
                    <template x-if="!file.preview">
                        <span class="material-symbols-outlined flex-shrink-0 text-2xl text-slate-400">insert_drive_file</span>
                    </template>

                    {{-- Info do arquivo --}}
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-xs font-medium text-slate-700" x-text="file.name"></p>
                        <p class="text-[10px] text-slate-400" x-text="formatSize(file.size)"></p>

                        {{-- Barra de progresso --}}
                        <div
                            x-show="file.progress > 0 && file.progress < 100"
                            class="mt-1 h-1 w-full overflow-hidden rounded-full bg-slate-200"
                        >
                            <div
                                class="h-full bg-primary transition-all duration-300"
                                :style="`width: ${file.progress}%`"
                            ></div>
                        </div>
                    </div>

                    {{-- Botão remover --}}
                    <button
                        type="button"
                        x-on:click.stop="removeFile(index)"
                        class="flex-shrink-0 rounded p-1 text-slate-400 transition-colors hover:bg-red-50 hover:text-red-500"
                        title="Remover arquivo"
                    >
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            </template>
        </div>
    </template>
</div>
