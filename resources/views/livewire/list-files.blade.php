<x-filament::section collapsible>
    <x-slot name="heading">
        Recent files
    </x-slot>
    <x-slot name="description">
        This section displays users' most recently uploaded files.
    </x-slot>

    <x-filament-tables::container>
        <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
            <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    <th class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1"></th>
                    <th class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1">Filename</th>
                    <th class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1">Author</th>
                    <th class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1">Date Modified</th>
                    <th class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1">Size</th>
                    <th class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1"></th>
                </tr>
            </thead>
        </table>
    </x-filament-tables::container>
    {{-- Content --}}
</x-filament::section>
