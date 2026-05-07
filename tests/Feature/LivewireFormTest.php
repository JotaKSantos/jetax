<?php

use Livewire\Component;
use Livewire\Livewire;

// Componente temporário para teste
class FormTestComponent extends Component
{
    public string $name = '';

    protected $rules = ['name' => 'required|min:3'];

    public function submit(): void
    {
        $this->validate();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <x-jetax-form-group label="Nome" name="name">
                <x-jetax-input name="name" wire:model="name" />
            </x-jetax-form-group>
            <button wire:click="submit">Salvar</button>
        </div>
        HTML;
    }
}

it('test_input_syncs_with_livewire_property', function () {
    Livewire::test(FormTestComponent::class)
        ->set('name', 'João')
        ->assertSet('name', 'João');
});

it('test_validation_error_displayed_after_submit', function () {
    Livewire::test(FormTestComponent::class)
        ->set('name', '')
        ->call('submit')
        ->assertHasErrors(['name' => 'required']);
});
