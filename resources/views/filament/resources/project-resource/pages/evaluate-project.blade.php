<x-filament-panels::page>
    {{-- @if (count($this->getInfolist('infolist')->getComponents()))
    <x-filament::grid>
        {{ $this->infolist }}
    </x-filament::grid>
    @endif --}}

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
    </x-filament-panels::form>
</x-filament-panels::page>
