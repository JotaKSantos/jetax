@php
use Illuminate\Pagination\LengthAwarePaginator;

$paginator = new LengthAwarePaginator(
    items: collect(range(1, 15)),
    total: 150,
    perPage: 15,
    currentPage: 3,
);

$codeBasic = <<<'BLADE'
<x-jetax-pagination :paginator="$paginator" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full">
            <x-jetax-pagination :paginator="$paginator" />
        </div>
    </x-jetax-docs-preview-section>

</div>
