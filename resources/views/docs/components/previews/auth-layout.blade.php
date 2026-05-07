@php
$codeLogin = <<<'BLADE'
<x-jetax-auth-layout title="Entrar" subtitle="Acesse sua conta para continuar.">
    <form class="space-y-5">
        <x-jetax-input label="E-mail" type="email" placeholder="seu@email.com" />
        <x-jetax-input label="Senha" type="password" />
        <x-jetax-button :block="true">Entrar</x-jetax-button>
    </form>
</x-jetax-auth-layout>
BLADE;

$codeRegistro = <<<'BLADE'
<x-jetax-auth-layout title="Criar Conta" subtitle="Preencha os dados para se registrar.">
    <form class="space-y-5">
        <x-jetax-input label="Nome" placeholder="Seu nome completo" />
        <x-jetax-input label="E-mail" type="email" placeholder="seu@email.com" />
        <x-jetax-input label="Senha" type="password" />
        <x-jetax-input label="Confirmar Senha" type="password" />
        <x-jetax-button :block="true">Criar Conta</x-jetax-button>
    </form>
</x-jetax-auth-layout>
BLADE;

$codeLogo = <<<'BLADE'
<x-jetax-auth-layout
    title="Entrar"
    subtitle="Bem-vindo de volta."
    logo="/img/logo.svg"
>
    <form class="space-y-5">
        <x-jetax-input label="E-mail" type="email" />
        <x-jetax-input label="Senha" type="password" />
        <x-jetax-button :block="true">Entrar</x-jetax-button>
    </form>
</x-jetax-auth-layout>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Link para preview completo --}}
    <div class="flex items-center gap-3 p-4 rounded-xl bg-surface-container-low dark:bg-white/5 border border-outline-variant/20 dark:border-white/10">
        <span class="material-symbols-outlined text-primary-container">open_in_new</span>
        <div>
            <p class="text-sm text-on-surface dark:text-white/80">
                Este componente e um layout de pagina completo e nao pode ser renderizado inline.
            </p>
            <a
                href="{{ route('jetax.docs.preview.auth-layout') }}"
                target="_blank"
                class="text-sm font-medium text-primary-container hover:underline"
            >
                Abrir preview em nova aba
            </a>
        </div>
    </div>

    {{-- Login --}}
    <x-jetax-docs-preview-section title="Login" :code="$codeLogin">
        <div class="flex rounded-xl overflow-hidden border border-outline-variant/20 dark:border-white/10 h-64 text-xs">
            {{-- Left panel mockup --}}
            <div class="hidden sm:flex w-1/2 bg-[#202947] flex-col items-center justify-center p-6 relative overflow-hidden">
                <div class="absolute -top-16 -left-16 w-48 h-48 rounded-full bg-primary-container blur-3xl opacity-10"></div>
                <div class="relative z-10 text-center">
                    <div class="mx-auto mb-3 w-10 h-10 rounded-lg bg-gradient-to-br from-primary-container to-info flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-lg">lock</span>
                    </div>
                    <p class="text-white font-bold text-lg">Jetax</p>
                    <p class="text-slate-400 text-[10px] uppercase tracking-wider">Design System</p>
                </div>
            </div>
            {{-- Right panel mockup --}}
            <div class="flex-1 flex items-center justify-center p-6 bg-surface-container-lowest dark:bg-[rgb(15,18,27)]">
                <div class="w-full max-w-[180px] space-y-3">
                    <div>
                        <p class="text-on-surface dark:text-white font-bold text-sm">Entrar</p>
                        <p class="text-on-surface-variant dark:text-white/50 text-[10px]">Acesse sua conta para continuar.</p>
                    </div>
                    <div class="h-7 rounded-lg bg-surface-container dark:bg-white/5"></div>
                    <div class="h-7 rounded-lg bg-surface-container dark:bg-white/5"></div>
                    <div class="h-7 rounded-lg bg-primary-container"></div>
                </div>
            </div>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Registro --}}
    <x-jetax-docs-preview-section title="Registro" :code="$codeRegistro">
        <div class="flex rounded-xl overflow-hidden border border-outline-variant/20 dark:border-white/10 h-72 text-xs">
            {{-- Left panel mockup --}}
            <div class="hidden sm:flex w-1/2 bg-[#202947] flex-col items-center justify-center p-6 relative overflow-hidden">
                <div class="absolute -top-16 -left-16 w-48 h-48 rounded-full bg-primary-container blur-3xl opacity-10"></div>
                <div class="relative z-10 text-center">
                    <div class="mx-auto mb-3 w-10 h-10 rounded-lg bg-gradient-to-br from-primary-container to-info flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-lg">lock</span>
                    </div>
                    <p class="text-white font-bold text-lg">Jetax</p>
                    <p class="text-slate-400 text-[10px] uppercase tracking-wider">Design System</p>
                </div>
            </div>
            {{-- Right panel mockup --}}
            <div class="flex-1 flex items-center justify-center p-6 bg-surface-container-lowest dark:bg-[rgb(15,18,27)]">
                <div class="w-full max-w-[180px] space-y-3">
                    <div>
                        <p class="text-on-surface dark:text-white font-bold text-sm">Criar Conta</p>
                        <p class="text-on-surface-variant dark:text-white/50 text-[10px]">Preencha os dados para se registrar.</p>
                    </div>
                    <div class="h-7 rounded-lg bg-surface-container dark:bg-white/5"></div>
                    <div class="h-7 rounded-lg bg-surface-container dark:bg-white/5"></div>
                    <div class="h-7 rounded-lg bg-surface-container dark:bg-white/5"></div>
                    <div class="h-7 rounded-lg bg-surface-container dark:bg-white/5"></div>
                    <div class="h-7 rounded-lg bg-primary-container"></div>
                </div>
            </div>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Logo --}}
    <x-jetax-docs-preview-section title="Com Logo" :code="$codeLogo">
        <div class="flex rounded-xl overflow-hidden border border-outline-variant/20 dark:border-white/10 h-64 text-xs">
            {{-- Left panel mockup com logo --}}
            <div class="hidden sm:flex w-1/2 bg-[#202947] flex-col items-center justify-center p-6 relative overflow-hidden">
                <div class="absolute -top-16 -left-16 w-48 h-48 rounded-full bg-primary-container blur-3xl opacity-10"></div>
                <div class="relative z-10 text-center">
                    <div class="mx-auto mb-3 w-10 h-10 rounded-lg bg-gradient-to-br from-primary-container to-info flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-lg">image</span>
                    </div>
                    <p class="text-white font-bold text-lg">Jetax</p>
                    <p class="text-slate-400 text-[10px] uppercase tracking-wider">Design System</p>
                </div>
            </div>
            {{-- Right panel mockup --}}
            <div class="flex-1 flex items-center justify-center p-6 bg-surface-container-lowest dark:bg-[rgb(15,18,27)]">
                <div class="w-full max-w-[180px] space-y-3">
                    <div>
                        <p class="text-on-surface dark:text-white font-bold text-sm">Entrar</p>
                        <p class="text-on-surface-variant dark:text-white/50 text-[10px]">Bem-vindo de volta.</p>
                    </div>
                    <div class="h-7 rounded-lg bg-surface-container dark:bg-white/5"></div>
                    <div class="h-7 rounded-lg bg-surface-container dark:bg-white/5"></div>
                    <div class="h-7 rounded-lg bg-primary-container"></div>
                </div>
            </div>
        </div>
    </x-jetax-docs-preview-section>

</div>
