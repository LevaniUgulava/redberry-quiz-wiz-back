<?php

namespace App\Filament\Resources\Quizzes\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class QuizForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Quiz Details')->schema([
                        Hidden::make('user_id')
                            ->default(fn () => Auth::user()?->id)
                            ->required(),
                        TextInput::make('title')->required(),
                        Select::make('difficulty_id')->label('Difficulty')->relationship('difficulty', 'name')->required(),
                        TextInput::make('time_limit')
                            ->label('Time (Minutes)')
                            ->numeric()
                            ->prefixIcon('heroicon-o-clock')
                            ->suffix('minutes')
                            ->minValue(1)
                            ->required()
                            ->dehydrateStateUsing(fn ($state) => (int) ($state * 60))
                            ->formatStateUsing(fn ($state) => $state ? $state / 60 : null),
                        CheckboxList::make('categories')
                            ->relationship('categories', 'name')
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable()
                            ->gridDirection('row')
                            ->required(),
                        Hidden::make('points')
                            ->dehydrateStateUsing(function ($state, $get) {
                                $questions = $get('questions') ?? [];
                                $totalPoint = collect($questions)->sum(function ($question) {
                                    return $question['points'] ?? 0;
                                });

                                return $totalPoint;
                            }),
                        FileUpload::make('image_url')
                            ->label('Quiz Image')
                            ->image()
                            ->visibility('public')
                            ->required(),
                    ]),
                    Step::make('Questions & Answers')->schema([
                        Repeater::make('questions')
                            ->label('Questions')
                            ->collapsible()
                            ->collapsed()
                            ->relationship('questions')
                            ->schema([
                                TextInput::make('question')->required(),
                                Select::make('type')->options(['one ans', 'two ans'])->required(),
                                TextInput::make('points')->prefixIcon('heroicon-o-star')->required()->numeric(),
                                Repeater::make('answers')
                                    ->label('Answers')
                                    ->relationship('answers')->schema([
                                        TextInput::make('answer')->required(),
                                        ToggleButtons::make('is_correct')
                                            ->label('is this answer correct?')
                                            ->boolean()
                                            ->inline()
                                            ->colors([true => 'success', false => 'danger'])
                                            ->default(false),
                                    ])->columns(2),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? null),
                    ]),
                ])->columnSpanFull(),

            ]);
    }
}
