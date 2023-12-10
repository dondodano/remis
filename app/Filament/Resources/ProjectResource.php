<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use App\Enums\MemberRole;
use Filament\Tables\Table;
use App\Enums\FundCategory;
use App\Enums\ProjectStatus;
use App\Models\ProjectMember;
use App\Enums\ProjectCategory;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Tables\Actions\CreateAction;
use App\Models\ProjectAttachment;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Grid;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProjectResource\Pages;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProjectResource\RelationManagers\DocumentsRelationManager;


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

                    Section::make('Project Members')
                    ->description('Enter the member involve from the project.')
                    //->collapsible()
                    ->collapsed()
                    ->columnSpan(2)
                    ->schema([
                        Repeater::make('members')
                            ->relationship()
                            ->addActionLabel('Add new project member')
                            ->schema([
                                TextInput::make('first_name')->autocapitalize('words')->required(),
                                TextInput::make('last_name')->autocapitalize('words')->required(),
                                Select::make('member_role')
                                    ->default('member')
                                    ->options(MemberRole::class)->columnSpan(2),
                            ])
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Project $project): array {
                                $nameWithSpace = $data['first_name'].' '.$data['last_name'];
                                $nameWithPlus = str_replace(' ', '+', $nameWithSpace);


                                $data +=  [
                                    'avatar' => 'https://ui-avatars.com/api/?background=random&size=128&rounded=true&bold=true&format=svg&name='.$nameWithPlus,
                                    'project_id' => $project->id
                                ];
                                return $data;
                            })
                            ->defaultItems(2)
                            ->reorderable()
                            ->reorderableWithDragAndDrop()
                            ->cloneable()
                            ->collapsible()
                            ->columns(2),
                    ]),

                    Section::make('Attachments')
                    ->description('Files acceptable are the following: .pdf, .jpeg,. png, .docx, .xml and .zip')
                    ->collapsed()
                    //->collapsible()
                    ->schema([
                        FileUpload::make('attachments')
                            ->label('Upload files here')
                            ->downloadable()
                            ->reorderable()
                            ->appendFiles()
                            ->openable()
                            ->previewable(false)
                            ->preserveFilenames()
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
                            ->directory('/public/attachments/'. randomStr())
                        ->multiple(),
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
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->wrap()
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('budget')
                    ->label('Budget')
                    ->money('PHP')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                ImageColumn::make('members.avatar')
                    ->label('Members')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->ring(5)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->overlap(2)
                    ->limitedRemainingText()
                    ->checkFileExistence(false),

                TextColumn::make('start_at')
                    ->label('Duration')
                    ->badge()
                    ->color(Color::Amber)
                    ->formatStateUsing(function($state, Project $project){
                        return date('Y-m-d', strtotime($project->start_at)) .' | '. date('Y-m-d', strtotime($project->end_at));
                    })
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('project_category')
                    ->label('Category')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('fund_category')
                    ->label('Fund')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                BadgeColumn::make('project_status')
                    ->label('Status')
                    ->colors(['primary'])
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->icon('heroicon-m-clock')
                    ->since(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('project_status')
                    ->label('Project Status')
                    ->options(ProjectStatus::class),
            ])
            ->actions([
                EditAction::make()
                ->label('')->color('gray')->tooltip('Edit project')
                    //methods below can be executed when edit is on modal
                    ->mutateFormDataUsing(function (array $data): array {
                        $project = static::getModel()::first();
                        $projectAttachment = ProjectAttachment::where('project_id', $project->id);
                        $files = $data['attachments'];

                        if( count($files) == $projectAttachment->count())
                        {
                            //update
                            foreach($files as $file)
                            {
                                ProjectAttachment::where('project_id', $project->id)
                                    ->update([
                                        'file_path' => $file
                                    ]);
                            }
                        }

                        if(count($files) > $projectAttachment->count())
                        {
                            //update & insert
                            foreach($files as $file)
                            {
                                ProjectAttachment::updateOrCreate([
                                        'file_path' => $file,
                                        'project_id' => $project->id
                                    ]);
                            }
                        }

                        if(count($files) < $projectAttachment->count())
                        {
                            $fileOnly = [];
                            foreach($projectAttachment->get()->toArray() as $item)
                            {
                                array_push($fileOnly, $item['file_path']);
                            }

                            $removedFiles = array_merge(
                                array_diff($fileOnly, $files),
                                array_diff($files, $fileOnly)
                            );

                            foreach($removedFiles as $rmFile)
                            {
                                ProjectAttachment::where('file_path', $rmFile)
                                    ->where('project_id', $project->id)->delete();
                            }


                            //delete & update
                            foreach($files as $file)
                            {
                                ProjectAttachment::updateOrCreate([
                                    'file_path' => $file,
                                    'project_id' => $project->id
                                ]);
                            }

                        }
                        return $data;
                    })->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Project updated')
                            ->body('The project has been saved successfully.'),
                    )
                ->hidden(fn ($record) => !is_null($record->deleted_at)),

                RestoreAction::make()
                ->label('')->color('gray')->tooltip('Restore project')
                ->after(function (RestoreAction $action, Project $project) {
                    Project::withTrashed()->find($project->id)->restore();
                    Notification::make()
                        ->success()
                        ->title('Project restored')
                        ->body("The {$project->title} has been deleted successfully.");
                }),

                ActionGroup::make([
                    ViewAction::make()->label('View')->color('gray')
                        ->hidden(fn ($record) => !is_null($record->deleted_at)),

                    Tables\Actions\Action::make('upload')
                    ->label('Upload')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('gray')
                    ->form([
                        FileUpload::make('attachments')
                            ->label('Upload files here')
                            ->downloadable()
                            ->reorderable()
                            ->appendFiles()
                            ->openable()
                            ->previewable(false)
                            ->preserveFilenames()
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
                            ->directory('/public/attachments/'. randomStr())
                        ->multiple(),
                    ])
                    ->hidden(fn ($record) => !is_null($record->deleted_at)),

                    DeleteAction::make()
                    ->label('Delete')->color('gray')
                    ->hidden(fn ($record) => !is_null($record->deleted_at))
                    ->after(function (DeleteAction $action, Project $project) {
                        $project->delete();

                        Notification::make()
                            ->success()
                            ->title('Project deleted')
                            ->body("The {$project->title} has been deleted successfully.");
                    }),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add new project')
                    ->icon('heroicon-m-plus'),
            ])
            ->emptyStateDescription('Once you add new project, it will appear here.');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make(3)
                ->schema([
                    TextEntry::make('title')
                        ->icon('heroicon-m-rectangle-group')
                        ->size(TextEntry\TextEntrySize::Medium)
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

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            //'edit' => Pages\EditProject::route('/{record}/edit'),
            //'upload' => Pages\UploadProjectAttachment::route('/{record}/upload'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
