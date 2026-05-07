@php
    $sizeClasses = $sizeClasses();
    $roundedClass = $roundedClass();
    $textSizeClass = $textSizeClass();
    $statusDot = $statusDotClasses();
    $baseClasses = "relative inline-flex items-center justify-center flex-shrink-0 shadow-[0_0_16px_rgba(0,0,0,0.05)] border border-[rgba(191,199,213,0.1)] {$sizeClasses} {$roundedClass}";
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if($src)
        {{-- Avatar com imagem e fallback para iniciais --}}
        <img
            src="{{ $src }}"
            alt="{{ $name }}"
            class="w-full h-full object-cover {{ $roundedClass }}"
            x-data="{ error: false }"
            x-on:error="error = true"
            x-show="!error"
        />
        <span
            x-data="{ error: false }"
            x-on:error.window="error = true"
            x-show="error"
            class="absolute inset-0 flex items-center justify-center w-full h-full {{ $roundedClass }} {{ $initialsColor }} font-bold text-white {{ $textSizeClass }}"
            style="display: none;"
        >{{ $initials }}</span>
    @else
        {{-- Avatar com iniciais --}}
        <span class="flex items-center justify-center w-full h-full {{ $roundedClass }} {{ $initialsColor }} font-bold text-white {{ $textSizeClass }}">
            {{ $initials }}
        </span>
    @endif

    @if($status)
        @php
            $dotColor = $statusDot['color'];
            $dotPosition = $statusDot['position'];
        @endphp
        <span class="absolute {{ $dotPosition }} block h-4 w-4 rounded-full ring-4 ring-white {{ $dotColor }}"></span>
    @endif
</div>
