<x-jetax-auth-layout title="Entrar" subtitle="Acesse sua conta para continuar.">
    <form class="space-y-5" onsubmit="return false;">
        <x-jetax-input label="E-mail" type="email" placeholder="seu@email.com" />
        <x-jetax-input label="Senha" type="password" placeholder="Sua senha" />

        <div class="flex items-center justify-between">
            <x-jetax-checkbox label="Lembrar de mim" />
            <a href="#" class="text-sm text-primary-container hover:underline">Esqueceu a senha?</a>
        </div>

        <x-jetax-button :block="true">Entrar</x-jetax-button>

        <p class="text-center text-sm text-on-surface-variant dark:text-white/60">
            Nao tem conta?
            <a href="#" class="text-primary-container hover:underline font-medium">Registre-se</a>
        </p>
    </form>
</x-jetax-auth-layout>
