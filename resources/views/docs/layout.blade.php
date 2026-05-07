<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Jetax — Design System' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .nav-link {
            display: block;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #374151;
            text-decoration: none;
            transition: background-color 0.15s, color 0.15s;
        }
        .nav-link:hover {
            background-color: #f3f4f6;
            color: #111827;
        }
        .nav-link.active {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-weight: 500;
        }
        pre { overflow-x: auto; }
        code { font-family: 'Courier New', monospace; font-size: 0.875rem; }
    </style>
</head>
<body class="h-full bg-gray-50">
    <div class="flex h-full">
        {{-- Sidebar de navegação --}}
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 overflow-y-auto">
            <div class="p-6">
                <a href="/docs" class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">J</span>
                    </div>
                    <span class="font-semibold text-gray-900 text-lg">Jetax</span>
                    <span class="text-xs text-gray-400 mt-0.5">docs</span>
                </a>

                <nav class="space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Geral</p>
                    <a href="/docs" class="nav-link {{ request()->is('docs') ? 'active' : '' }}">
                        Visão Geral
                    </a>
                    <a href="/docs/getting-started" class="nav-link {{ request()->is('docs/getting-started') ? 'active' : '' }}">
                        Primeiros Passos
                    </a>
                    <a href="/docs/customization" class="nav-link {{ request()->is('docs/customization') ? 'active' : '' }}">
                        Customização
                    </a>
                </nav>

                <hr class="my-4 border-gray-200">

                <nav class="space-y-4">
                    @php
                        $groups = \Jetax\DesignSystem\Docs\ComponentRegistry::all();
                        $currentComponent = request()->segment(3);
                    @endphp

                    @foreach($groups as $category => $items)
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                                {{ $category }}
                            </p>
                            @foreach($items as $item)
                                <a
                                    href="/docs/components/{{ $item['slug'] }}"
                                    class="nav-link {{ $currentComponent === $item['slug'] ? 'active' : '' }}"
                                >
                                    {{ $item['name'] }}
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </nav>
            </div>
        </aside>

        {{-- Área de conteúdo principal --}}
        <main class="flex-1 overflow-y-auto">
            <div class="max-w-4xl mx-auto px-8 py-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
