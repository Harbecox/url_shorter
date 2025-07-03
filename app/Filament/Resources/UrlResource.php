<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UrlResource\Pages;
use App\Filament\Resources\UrlResource\RelationManagers;
use App\Models\Url;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UrlResource extends Resource
{
    protected static ?string $model = Url::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('original_url')
                    ->label('Original URL')
                    ->required(),

                Forms\Components\TextInput::make('short_code')
                    ->label('Short Code')
                    ->readOnly()
                    ->disabled(fn ($livewire) => $livewire->getRecord() === null)
                    ->dehydrated(false)
                    ->afterStateHydrated(fn ($component, $state) => $component->state($state))
                    ->formatStateUsing(fn ($state) => url("/u/{$state}"))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('original_url')->label('Original URL'),
                TextColumn::make('short_code')
                    ->label('Short Link')
                    ->url(fn ($record) => url("/u/{$record->short_code}"),true)
                    ->formatStateUsing(fn ($state) => url("/u/{$state}")),
                TextColumn::make('clicks_count')
                    ->label('Clicks')
                    ->counts('clicks')
                    ->sortable()
            ])
            ->recordUrl(fn ($record) => route('filament.app.resources.clicks.index',"tableFilters[url][value]=$record->id"))
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make('delete')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUrls::route('/'),
            'create' => Pages\CreateUrl::route('/create'),
//            'edit' => Pages\EditUrl::route('/{record}/edit'),
            'view' => Pages\ViewUrl::route('/{record}'),
        ];
    }
}
