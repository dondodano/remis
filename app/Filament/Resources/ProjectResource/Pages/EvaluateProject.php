<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use Filament\Forms\Form;
use App\Enums\MemberRole;
use App\Enums\FundCategory;
use App\Enums\ProjectStatus;
use App\Enums\ProjectCategory;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\ProjectResource;
use Filament\Forms\Concerns\InteractsWithForms;

class EvaluateProject extends Page implements HasForms
{
    use InteractsWithForms;

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

    public function save()
    {

    }

}
