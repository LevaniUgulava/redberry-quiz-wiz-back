<?php

namespace App\Filament\Resources\Quizzes;

use App\Filament\Resources\Quizzes\Pages\CreateQuiz;
use App\Filament\Resources\Quizzes\Pages\ListQuizzes;
use App\Filament\Resources\Quizzes\Pages\ViewQuiz;
use App\Filament\Resources\Quizzes\Schemas\QuizForm;
use App\Filament\Resources\Quizzes\Tables\QuizzesTable;
use App\Models\Quiz;
use BackedEnum;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Override;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'Quiz';

    #[Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return QuizForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuizzesTable::configure($table);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Quiz Info')->schema([
                Grid::make(5)->schema([
                    ImageEntry::make('image_url')
                        ->hiddenLabel()
                        ->circular()
                        ->height(120)
                        ->columnSpan(1),

                    TextEntry::make('title')
                        ->label('Quiz Title')
                        ->weight('bold')
                        ->columnSpan(1),
                    TextEntry::make('difficulty.name')
                        ->label('Difficulty')
                        ->badge()
                        ->color(function ($record) {
                            $hex = $record->difficulty?->hex ?? '#808080';

                            return Color::rgb($hex);
                        })->columnSpan(1),
                    TextEntry::make('points')
                        ->label('Max Points')
                        ->icon('heroicon-o-star')
                        ->iconColor('warning')
                        ->numeric()
                        ->weight('semibold')->columnSpan(1),

                    TextEntry::make('time_limit')
                        ->label('Time Limit')
                        ->icon('heroicon-o-clock')
                        ->iconColor('gray')
                        ->suffix(' min')
                        ->formatStateUsing(fn ($state) => $state ? $state / 60 : null)
                        ->placeholder('No limit')->columnSpan(1),
                ]),
            ])->columnSpanFull(),
            RepeatableEntry::make('questions')
                ->hiddenLabel()
                ->contained(false)
                ->schema([
                    Section::make(fn ($record) => $record->question)
                        ->description(fn ($record) => $record->type?->getLabel())
                        ->collapsible()
                        ->collapsed()
                        ->schema([
                            TextEntry::make('points')->hiddenLabel()->icon('heroicon-o-star')
                                ->iconColor('warning'),
                            RepeatableEntry::make('answers')
                                ->hiddenLabel()
                                ->grid(2)
                                ->schema([
                                    TextEntry::make('answer')
                                        ->hiddenLabel()
                                        ->icon(fn ($record) => $record->is_correct
                                            ? 'heroicon-o-check-circle'
                                            : null)
                                        ->iconColor(fn ($record) => $record->is_correct
                                            ? 'success'
                                            : 'gray')
                                        ->color(fn ($record) => $record->is_correct
                                            ? 'success'
                                            : null)
                                        ->weight(fn ($record) => $record->is_correct
                                            ? 'semibold'
                                            : null),
                                ]),
                        ]),
                ])->columnSpanFull(),

        ]);
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
            'index' => ListQuizzes::route('/'),
            'create' => CreateQuiz::route('/create'),
            'view' => ViewQuiz::route('/{record}'),

        ];
    }
}
