<x-filament-panels::page>
    {{-- @if (count($this->getInfolist('infolist')->getComponents()))
        {{ $this->infolist }}
    @endif --}}

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
    </x-filament-panels::form>
</x-filament-panels::page>
