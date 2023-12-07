<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\FundCategory;
use App\Enums\ProjectStatus;
use App\Enums\ProjectCategory;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProjectResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProjectResource\RelationManagers;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Record';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
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

                    Section::make('Attachments')
                    ->schema([
                        FileUpload::make('attachments')
                            ->label('Upload files here')
                            ->downloadable()
                            ->reorderable()
                            ->appendFiles()
                            ->openable()
                            ->previewable(false)
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/jpeg',
                                'image/png',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/x-zip-compressed'
                            ])
                            ->disk('local')
                            ->directory('/public/attachments')
                        ->multiple()
                    ])->columnSpan(2),// end Section 2
                ])->columnSpan(['lg' => 2]),// end Group 1


                Group::make()
                ->schema([
                    Section::make('Project duration')
                    ->schema([
                        DatePicker::make('start_at')
                            ->label('Start Date')
                            ->helperText("Enter the start date of the project.")
                            ->required()
                            ->firstDayOfWeek(7)
                            ->default(now())
                            ->format('Y-m-d')
                            ->closeOnDateSelection()
                        ->displayFormat('Y-m-d'),

                        DatePicker::make('end_at')
                            ->label('End Date')
                            ->helperText("Enter the end date of the project.")
                            ->required()
                            ->firstDayOfWeek(7)
                            ->default(now())
                            ->format('Y-m-d')
                            ->closeOnDateSelection()
                        ->displayFormat('Y-m-d'),
                    ])->columnSpan(2),

                    Section::make()
                    ->schema([
                        Select::make('project_category')
                            ->label('Project Category')
                            ->helperText("Enter the project category of the project.")
                            ->required()
                            ->default('research')
                        ->options(ProjectCategory::class),


                        Select::make('project_status')
                            ->label('Status')
                            ->helperText("Enter the project status of the project.")
                            ->required()
                            ->default('underevaluation')
                        ->options(ProjectStatus::class),
                    ])->columnSpan(2),

                ])->columnSpan(['lg' => 1]),// end Group 2

            ])->columns(3);//end Schema
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('budget')
                    ->label('Budget')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                ImageColumn::make('project_leader')
                    ->label('Leader')
                    ->circular(),
                ImageColumn::make('project_member')
                    ->label('Members')
                    ->circular()
                    ->stacked(),
                TextColumn::make('start_at')
                    ->label('Duration')
                    ->badge()
                    ->color(Color::Amber)
                    ->formatStateUsing(function($state, Project $project){
                        return date('Y-m-d', strtotime($project->start_at)) .' | '. date('Y-m-d', strtotime($project->end_at));
                    })
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('project_category')
                    ->label('Category')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('fund_category')
                    ->label('Fund')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('project_status')
                    ->label('Status')
                    ->badge()
                    ->color(Color::Blue)
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('')->color('gray')->tooltip('Edit user')
                    //methods below can be executed when edit is on modal
                    ->mutateFormDataUsing(function (array $data): array {
                        return $data;
                    })->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Project updated')
                            ->body('The project has been saved successfully.'),
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add new project')
                    ->icon('heroicon-m-plus'),
            ])
            ->emptyStateDescription('Once you add new project, it will appear here.');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            //'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
