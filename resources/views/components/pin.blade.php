<div
    x-data="{
        digits: Array({{ $length }}).fill(''),
        get value() {
            return this.digits.join('');
        },
        handleInput(index, event) {
            const input = event.target;
            const val = input.value;

            if (val.length > 1) {
                return;
            }

            @if($type === 'numeric')
            if (val && !/[0-9]/.test(val)) {
                input.value = this.digits[index] || '';
                return;
            }
            @else
            if (val && !/[a-zA-Z0-9]/.test(val)) {
                input.value = this.digits[index] || '';
                return;
            }
            @endif

            this.digits[index] = val;

            if (val && index < {{ $length - 1 }}) {
                $refs['pin_' + (index + 1)].focus();
            }
        },
        handleKeydown(index, event) {
            if (event.key === 'Backspace') {
                if (!this.digits[index] && index > 0) {
                    this.digits[index - 1] = '';
                    $refs['pin_' + (index - 1)].focus();
                } else {
                    this.digits[index] = '';
                }
            } else if (event.key === 'ArrowLeft' && index > 0) {
                $refs['pin_' + (index - 1)].focus();
            } else if (event.key === 'ArrowRight' && index < {{ $length - 1 }}) {
                $refs['pin_' + (index + 1)].focus();
            }
        },
        handlePaste(event) {
            event.preventDefault();
            const pasted = (event.clipboardData || window.clipboardData).getData('text');
            @if($type === 'numeric')
            const filtered = pasted.replace(/[^0-9]/g, '');
            @else
            const filtered = pasted.replace(/[^a-zA-Z0-9]/g, '');
            @endif
            const chars = filtered.split('').slice(0, {{ $length }});

            chars.forEach((char, i) => {
                this.digits[i] = char;
            });

            const nextIndex = Math.min(chars.length, {{ $length - 1 }});
            this.$nextTick(() => {
                $refs['pin_' + nextIndex].focus();
            });
        }
    }"
    class="flex items-center gap-2"
>
    @for ($i = 0; $i < $length; $i++)
        <input
            type="text"
            maxlength="1"
            x-ref="pin_{{ $i }}"
            :value="digits[{{ $i }}]"
            x-on:input="handleInput({{ $i }}, $event)"
            x-on:keydown="handleKeydown({{ $i }}, $event)"
            x-on:paste="{{ $i === 0 ? 'handlePaste($event)' : 'handlePaste($event)' }}"
            inputmode="{{ $inputMode() }}"
            pattern="{{ $pattern() }}"
            autocomplete="one-time-code"
            class="w-10 h-12 text-center text-lg font-semibold rounded-lg border border-outline-variant bg-surface-input text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 transition-all"
        />
    @endfor

    <input
        type="hidden"
        :value="value"
        {{ $attributes->whereStartsWith('wire:model') }}
    />
</div>
