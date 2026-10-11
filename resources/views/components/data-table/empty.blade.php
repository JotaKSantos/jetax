@props([
    'title' => 'Nenhum registro encontrado',
    'description' => '',
    'icon' => 'inbox',
])

<x-jetax-empty-state {{ $attributes }} :title="$title" :description="$description" :icon="$icon" type="no-results" />
