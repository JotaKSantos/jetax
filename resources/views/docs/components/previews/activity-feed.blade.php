@php
$codeBasico = <<<'BLADE'
<x-jetax-activity-feed>
    <x-jetax-activity-feed-item
        type="created"
        description="Registro criado com sucesso."
        author="Ana Lima"
        timestamp="ha 5 min"
    />
    <x-jetax-activity-feed-item
        type="updated"
        description="Status alterado para ativo."
        author="Joao Silva"
        timestamp="ha 15 min"
    />
    <x-jetax-activity-feed-item
        type="commented"
        description="Adicionou um comentario ao registro."
        author="Maria Santos"
        timestamp="ha 1 hora"
    />
</x-jetax-activity-feed>
BLADE;

$codeDateLabels = <<<'BLADE'
<x-jetax-activity-feed>
    <x-jetax-activity-feed-item
        date-label="Hoje"
        type="created"
        description="Novo usuario cadastrado."
        author="Sistema"
        timestamp="09:30"
    />
    <x-jetax-activity-feed-item
        type="updated"
        description="Plano atualizado para Pro."
        author="Admin"
        timestamp="08:15"
    />
    <x-jetax-activity-feed-item
        date-label="Ontem"
        type="status"
        description="Status alterado para pendente."
        author="Joao Silva"
        timestamp="17:45"
    />
</x-jetax-activity-feed>
BLADE;

$codeTipos = <<<'BLADE'
<x-jetax-activity-feed>
    <x-jetax-activity-feed-item type="created" description="Registro criado." author="Ana" timestamp="10:00" />
    <x-jetax-activity-feed-item type="updated" description="Registro atualizado." author="Joao" timestamp="10:15" />
    <x-jetax-activity-feed-item type="commented" description="Comentario adicionado." author="Maria" timestamp="10:30" />
    <x-jetax-activity-feed-item type="status" description="Status alterado." author="Admin" timestamp="10:45" />
    <x-jetax-activity-feed-item type="default" description="Acao generica." author="Sistema" timestamp="11:00" />
</x-jetax-activity-feed>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <div class="max-w-lg">
            <x-jetax-activity-feed>
                <x-jetax-activity-feed-item
                    type="created"
                    description="Registro criado com sucesso."
                    author="Ana Lima"
                    timestamp="ha 5 min"
                />
                <x-jetax-activity-feed-item
                    type="updated"
                    description="Status alterado para ativo."
                    author="Joao Silva"
                    timestamp="ha 15 min"
                />
                <x-jetax-activity-feed-item
                    type="commented"
                    description="Adicionou um comentario ao registro."
                    author="Maria Santos"
                    timestamp="ha 1 hora"
                />
            </x-jetax-activity-feed>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Date Labels --}}
    <x-jetax-docs-preview-section title="Com Date Labels" :code="$codeDateLabels">
        <div class="max-w-lg">
            <x-jetax-activity-feed>
                <x-jetax-activity-feed-item
                    date-label="Hoje"
                    type="created"
                    description="Novo usuario cadastrado."
                    author="Sistema"
                    timestamp="09:30"
                />
                <x-jetax-activity-feed-item
                    type="updated"
                    description="Plano atualizado para Pro."
                    author="Admin"
                    timestamp="08:15"
                />
                <x-jetax-activity-feed-item
                    date-label="Ontem"
                    type="status"
                    description="Status alterado para pendente."
                    author="Joao Silva"
                    timestamp="17:45"
                />
            </x-jetax-activity-feed>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Tipos de Atividade --}}
    <x-jetax-docs-preview-section title="Tipos de Atividade" :code="$codeTipos">
        <div class="max-w-lg">
            <x-jetax-activity-feed>
                <x-jetax-activity-feed-item type="created" description="Registro criado." author="Ana" timestamp="10:00" />
                <x-jetax-activity-feed-item type="updated" description="Registro atualizado." author="Joao" timestamp="10:15" />
                <x-jetax-activity-feed-item type="commented" description="Comentario adicionado." author="Maria" timestamp="10:30" />
                <x-jetax-activity-feed-item type="status" description="Status alterado." author="Admin" timestamp="10:45" />
                <x-jetax-activity-feed-item type="default" description="Acao generica." author="Sistema" timestamp="11:00" />
            </x-jetax-activity-feed>
        </div>
    </x-jetax-docs-preview-section>

</div>
