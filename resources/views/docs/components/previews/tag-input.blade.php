@php
$codeBasic = <<<'BLADE'
<x-jetax-tag-input />
BLADE;

$codeSuggestions = <<<'BLADE'
<x-jetax-tag-input :suggestions="['PHP', 'Laravel', 'Vue.js', 'React', 'Tailwind CSS', 'Alpine.js']" />
BLADE;

$codeMax = <<<'BLADE'
<x-jetax-tag-input :max="3" :suggestions="['Design', 'Frontend', 'Backend', 'DevOps']" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full max-w-sm">
            <x-jetax-tag-input />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Sugestoes --}}
    <x-jetax-docs-preview-section title="Com Sugestoes" :code="$codeSuggestions">
        <div class="w-full max-w-sm">
            <x-jetax-tag-input :suggestions="['PHP', 'Laravel', 'Vue.js', 'React', 'Tailwind CSS', 'Alpine.js']" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Limite --}}
    <x-jetax-docs-preview-section title="Com Limite Maximo" :code="$codeMax">
        <div class="w-full max-w-sm">
            <x-jetax-tag-input :max="3" :suggestions="['Design', 'Frontend', 'Backend', 'DevOps']" />
        </div>
    </x-jetax-docs-preview-section>

</div>
