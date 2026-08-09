<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers\EmployeesRelationManager;
use App\Models\City;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    protected static string|UnitEnum|null $navigationGroup = 'System Management';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('City Information')
                    ->description('Manage city details and location information')
                    ->schema([
                        Select::make('state_id')
                            ->relationship('state', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Select a state'),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter city name')
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('state.name')
                    ->label('State')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('State name copied')
                    ->copyMessageDuration(1500),
                TextColumn::make('name')
                    ->label('City Name')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('City name copied')
                    ->copyMessageDuration(1500),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No cities found')
            ->emptyStateDescription('Create your first city to get started.')
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            EmployeesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
