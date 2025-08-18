<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                 Section::make()
                    ->schema([
                        Select::make('country_id')
                            ->label('Country')
                            ->options(Country::all()->pluck('name', 'id')->toArray())
                            ->afterStateUpdated(
                                fn (callable $set) => $set('state_id', null)
                            )
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('state_id')
                            ->label('State')
                            ->options(
                                function (callable $get) {
                                    $country = Country::find($get('country_id'));

                                    if(!$country) {
                                        return State::all()->pluck('name', 'id');
                                    }
                                    return $country->states->pluck('name', 'id');
                                }
                            )
                            ->afterStateUpdated(
                                fn (callable $set) => $set('city_id', null)
                            )
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('city_id')
                        ->label('City')
                            ->options(function (callable $get) {
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
