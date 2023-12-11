<x-filament-panels::page>
    {{-- <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
    </x-filament-panels::form> --}}
    <form method="POST" wire:submit="save">
        {{ $this->form }}
    </form>
</x-filament-panels::page>
