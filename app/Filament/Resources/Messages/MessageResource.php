<?php

namespace App\Filament\Resources\Messages;

use App\Filament\Resources\Messages\Pages\ManageMessages;
use App\Models\Message;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $recordTitleAttribute = 'question';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextEntry::make('user.name')
                    ->label('User name'),
                TextEntry::make('user.email')
                    ->label('User email'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('question')
                    ->columnSpanFull(),
                Textarea::make('answer')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextEntry::make('user.name')
                    ->label('User name'),
                TextEntry::make('user.email')
                    ->label('User email'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('question')
                    ->columnSpanFull(),
                TextEntry::make('answer')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->defaultPaginationPageOption(25)
            ->recordClasses(static fn (Message $record): ?string => blank($record->answer) ? 'bg-amber-500/10' : null)
            ->columns([
                IconColumn::make('requires_human')
                    ->label('Status')
                    ->boolean()
                    ->getStateUsing(function (Message $record) {
                        if (blank($record->answer)) {
                            return false;
                        }

                        return ! $record->requires_human;
                    })
                    ->falseIcon(Heroicon::OutlinedExclamationCircle)
                    ->falseColor(Color::Amber),
                TextColumn::make('question')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('hide_answered')
                    ->label('Hide answered')
                    ->query(static fn (Builder $query) => $query->whereNull('answer')),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->hidden(static fn (Message $record): bool => blank($record->answer)),
                EditAction::make()
                    ->iconButton()
                    ->hidden(static fn (Message $record): bool => filled($record->answer)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMessages::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user:id,name,email');
    }
}
