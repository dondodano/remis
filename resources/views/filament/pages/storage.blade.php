<x-filament-panels::page>
    <div>
        @livewire(\App\Filament\Widgets\StorageStatOverview::class)
    </div>

    {{-- {{ $this->infolist }} --}}

    <div>
        @livewire(\App\Filament\Widgets\StorageChart::class)
    </div>
</x-filament-panels::page>
