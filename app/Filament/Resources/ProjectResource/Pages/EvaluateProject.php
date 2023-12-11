<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Models\Project;
use Filament\Forms\Form;
use App\Enums\MemberRole;
use App\Enums\FundCategory;
use App\Enums\ProjectStatus;
use App\Enums\ProjectCategory;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Grid;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\ProjectResource;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Components\TextEntry\TextEntrySize;

class EvaluateProject extends Page implements HasForms, HasInfolists
{
    use InteractsWithForms, InteractsWithInfolists;

    public ?array $data = [];

    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.project-resource.pages.evaluate-project';

    public function mount(): void
    {
        static::authorizeResourceAccess();
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                ->schema([
                    Section::make('Project information')
                    ->description('Please enter project information in the fields below. (Perspective of data entry : REMIS, Proponent and RIDE Staff)')
                    ->icon('heroicon-m-folder')
                    ->schema([
                        Textarea::make('title')
                            ->label('Title')
                            ->hint('Project tile')
                            ->hintIcon('heroicon-m-information-circle')
                            ->helperText("Enter the title of the project.")
                            ->required()
                            ->autosize()
                        ->maxLength(255)->columnSpan(2),

                        TextInput::make('budget')
                            ->label('Budget')
                            ->hint('in Philippine peso')
                            ->hintIcon('heroicon-m-information-circle')
                            ->helperText("Enter the budget of the project.")
                            ->required()
                            ->inputMode('decimal')
                            ->step(100)
                            ->numeric()
                        ->maxLength(255),

                        Select::make('fund_category')
                            ->label('Fund Category')
                            ->helperText("Select fund category.")
                            ->required()
                            ->default('internal')
                        ->options(FundCategory::class),

                    ])->columnSpan(2),// end Section 1

                ])->columnSpan(['lg' => 2]),// end Group 1


            ])->columns(3);//end Schema
    }


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Grid::make(3)
            ->schema([
                TextEntry::make('title')
                    ->icon('heroicon-m-rectangle-group')
                    ->size(TextEntrySize::Medium)
                    ->weight(FontWeight::Bold)
                    ->label('Project Title')
                    ->columnSpan(3),
                TextEntry::make('budget')
                    ->icon('heroicon-m-banknotes')
                    ->label('Budget')
                    ->money('PHP')
                    ->badge()
                    ->color(Color::Blue),
                TextEntry::make('start_at')
                    ->icon('heroicon-m-calendar')
                    ->label('Budget')
                    ->money('PHP')
                    ->badge()
                    ->color(Color::Amber)
                    ->formatStateUsing(function($state, Project $project){
                        return date('Y-m-d', strtotime($project->start_at)) .' | '. date('Y-m-d', strtotime($project->end_at));
                    }),
                TextEntry::make('project_category')
                    ->icon('heroicon-m-tag')
                    ->badge()
                    ->color(Color::Blue)
                    ->label('Category'),
                TextEntry::make('fund_category')
                    ->icon('heroicon-m-tag')
                    ->badge()
                    ->color(Color::Green)
                    ->label('Fund'),
                TextEntry::make('project_status')
                    ->icon('heroicon-m-tag')
                    ->badge()
                    ->color(Color::Indigo)
                    ->label('Status'),
                TextEntry::make('members')
                    ->icon('heroicon-m-user-circle')
                    ->listWithLineBreaks()
                    ->formatStateUsing(function($state){
                        return ucwords($state->first_name .' '. $state->last_name);
                    }),

                Fieldset::make('Attachment')
                    ->schema([
                        TextEntry::make('attachments')
                            ->label('')
                            ->icon('heroicon-m-paper-clip')
                            ->formatStateUsing(function(string $state){
                                $urlSegment = explode('/', $state);
                                $urlArray = [
                                    'storage',
                                    $urlSegment[1],
                                    $urlSegment[2],
                                    $urlSegment[3]
                                ];

                                $newUrl = implode('/', $urlArray);

                                return new HtmlString('<a href="../'.$newUrl.'" target="_blank">'.basename($state).'</a>');
                            })
                            ->helperText('Click each attachment to view.')
                            ->listWithLineBreaks(),
                    ]),
            ])
        ]);
    }

    public function save()
    {

    }
}
