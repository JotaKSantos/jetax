@props([
    'title' => 'Nenhum registro encontrado',
    'description' => '',
    'icon' => 'inbox',
])

<x-jetax-empty-state :title="$title" :description="$description" :icon="$icon" type="no-results" />
