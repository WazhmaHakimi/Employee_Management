<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\Widgets\EmployeeStatsOverview;
use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\State;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('country_id')
                            ->label('Country')
                            ->options(Country::all()->pluck('name', 'id')->toArray())
                            ->afterStateUpdated(
                                fn (Set $set) => $set('state_id', null)
                            )
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('state_id')
                            ->label('State')
                            ->options(
                                function (Get $get) {
                                    $country = Country::find($get('country_id'));

                                    if(!$country) {
                                        return State::all()->pluck('name', 'id');
                                    }
                                    return $country->states->pluck('name', 'id');
                                }
                            )
                            ->afterStateUpdated(
                                fn (Set $set) => $set('city_id', null)
                            )
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('city_id')
                        ->label('City')
                            ->options(function (Get $get) {
                                $state = State::find($get('state_id'));

                                if(!$state) {
                                    return City::all()->pluck('name', 'id');
                                }

                                return $state->cities->pluck('name', 'id');
                            })
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('first_name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('zip_code')
                            ->required()
                            ->maxLength(5)
                            ->columnSpanFull(),
                        DatePicker::make('birth_date')
                            ->before(now())
                            ->required(),
                        DatePicker::make('hired_date')
                            ->default(now())
                            ->required(),
                        Textarea::make('address')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('last_name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('country.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('state.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('city.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('department.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('birth_date')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('hired_date')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('department')
                    ->relationship('department', 'name')
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            EmployeeStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
