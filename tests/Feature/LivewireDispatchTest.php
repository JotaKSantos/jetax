<?php

use Livewire\Component;
use Livewire\Livewire;

class DispatchTestComponent extends Component
{
    public function openModal(): void
    {
        $this->dispatch('modal-open', id: 'test-modal');
    }

    public function closeModal(): void
    {
        $this->dispatch('modal-close', id: 'test-modal');
    }

    public function showToast(): void
    {
        $this->dispatch('toast', message: 'Item salvo!', variant: 'success');
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <x-jetax-modal id="test-modal">
                <x-slot:header>Teste</x-slot:header>
                Conteúdo do modal
            </x-jetax-modal>
            <x-jetax-toast-container />
            <button wire:click="openModal">Abrir</button>
            <button wire:click="closeModal">Fechar</button>
            <button wire:click="showToast">Toast</button>
        </div>
        HTML;
    }
}

it('test_modal_opens_via_livewire_dispatch', function () {
    Livewire::test(DispatchTestComponent::class)
        ->assertSeeHtml('modal-open.window')
        ->call('openModal')
        ->assertDispatched('modal-open', id: 'test-modal');
});

it('test_modal_closes_after_save', function () {
    Livewire::test(DispatchTestComponent::class)
        ->call('closeModal')
        ->assertDispatched('modal-close', id: 'test-modal');
});

it('test_toast_triggered_via_livewire_dispatch', function () {
    Livewire::test(DispatchTestComponent::class)
        ->call('showToast')
        ->assertDispatched('toast', message: 'Item salvo!', variant: 'success');
});
