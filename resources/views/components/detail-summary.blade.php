<div {{ $attributes->merge(['class' => 'p-6']) }}>
    <div class="{{ $gridClasses() }}">
        @foreach($items as $item)
            <div class="space-y-1">
                <p class="{{ $labelClasses() }}">{{ $item['label'] }}</p>
                <p class="{{ $valueClasses() }}">{{ $item['value'] }}</p>
            </div>
        @endforeach
    </div>
</div>
