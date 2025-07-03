<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClickResource\Pages;
use App\Filament\Resources\ClickResource\RelationManagers;
use App\Models\Click;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClickResource extends Resource
{
    protected static ?string $model = Click::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->join('urls', 'clicks.url_id', '=', 'urls.id')
            ->where('urls.user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('url.original_url')->label('URL'),
                Tables\Columns\TextColumn::make('ip_address')->label('IP'),
                Tables\Columns\TextColumn::make('created_at')->label('Clicked at'),
            ])
            ->recordUrl(Null)
            ->filters([
                Tables\Filters\SelectFilter::make('url')
                    ->relationship(
                        'url',
                        'id',
                        fn ($query) => $query->select(['id', 'original_url'])
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id} - {$record->original_url}")
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListClicks::route('/'),
            'create' => Pages\CreateClick::route('/create'),
            'edit' => Pages\EditClick::route('/{record}/edit'),
        ];
    }
}
