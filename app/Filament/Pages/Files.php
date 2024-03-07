<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use App\Filament\Widgets\FilesStatOverview;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Components\IconEntry\IconEntrySize;
use Filament\Infolists\Components\TextEntry\TextEntrySize;

class Files extends Page implements HasInfolists
{
    use InteractsWithInfolists;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Drive';

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static string $view = 'filament.pages.files';

    protected function getHeaderWidgets(): array
    {
        return [
            FilesStatOverview::class
        ];
    }

    // public function infolist(Infolist $infolist): Infolist
    // {
    //     $varInfoList =  $infolist
    //         ->state([
    //             'files' => [
    //                 0 => [
    //                     'name' => 'AngAlamatNgMahiwangBato.xls',
    //                     'author' => 'Dondo T. Dano',
    //                     'avatar' => "https://ui-avatars.com/api/?background=random&size=128&rounded=true&bold=true&format=svg&name=Dondo+Dano",
    //                     'last_modified' => '2024-03-07 03:04 PM',
    //                     'file_size' => '100 GB'
    //                 ],
    //                 1 => [
    //                     'name' => 'AngAlamatNgMahiwangBato.xlss',
    //                     'author' => 'Dondo T. DanoYeah',
    //                     'avatar' => "https://ui-avatars.com/api/?background=random&size=128&rounded=true&bold=true&format=svg&name=Dondo+Yeah",
    //                     'last_modified' => '2024-03-07 03:04 PM',
    //                     'file_size' => '101 GB'
    //                 ],
    //         ]
    //         ])
    //         ->schema([
    //             Section::make('Recent Files')
    //                 ->description('This section display users\' most recently uploaded files.')
    //                 ->schema([

    //                     RepeatableEntry::make('files')
    //                         ->label('')
    //                         ->schema([
    //                             TextEntry::make('name')
    //                                 ->label('')
    //                                 ->limit(10)
    //                                 ->tooltip(function (TextEntry $component): ?string {
    //                                     $state = $component->getState();
    //                                     if (strlen($state) <= $component->getCharacterLimit()) {
    //                                         return null;
    //                                     }
    //                                     return $state;
    //                                 }),
    //                             ImageEntry::make('avatar')
    //                                 ->label('')
    //                                 ->height(30)
    //                                 ->circular(),
    //                             TextEntry::make('author')
    //                                 ->label('')
    //                                 ->badge(),
    //                             TextEntry::make('last_modified')
    //                                 ->label('')
    //                                 ->badge()
    //                                 ->color('gray')
    //                                 ->size(TextEntrySize::ExtraSmall),
    //                             TextEntry::make('file_size')
    //                                 ->label(''),
    //                         ])
    //                         ->contained(false)
    //                         ->columns(5),
    //                 ])
    //                 ->collapsible(),

    //         ]);

    //     return $varInfoList;
    // }
}
