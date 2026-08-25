<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Employee Information')
                    ->schema([
                        Select::make('country_id')
                            ->label('Country')
                            ->options(Country::all()->pluck('name', 'id')->toArray())
                            ->afterStateUpdated(
                                fn(Set $set) => $set('state_id', null)
                            )
                            ->default(fn() => request()->get('country_id'))
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('state_id')
                            ->label('State')
                            ->options(
                                function (Get $get) {
                                    $country = Country::find($get('country_id'));

                                    if (!$country) {
                                        return State::all()->pluck('name', 'id');
                                    }
                                    return $country->states->pluck('name', 'id');
                                }
                            )
                            ->afterStateUpdated(
                                fn(Set $set) => $set('city_id', null)
                            )
                            ->default(fn() => request()->get('state_id'))
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('city_id')
                            ->label('City')
                            ->options(function (Get $get) {
                                $state = State::find($get('state_id'));

                                if (!$state) {
                                    return City::all()->pluck('name', 'id');
                                }

                                return $state->cities->pluck('name', 'id');
                            })
                            ->default(fn() => request()->get('city_id'))
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->default(fn() => request()->get('department_id'))
                            ->preload()
                            ->required(),
                        Select::make('position_id')
                            ->relationship('position', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('first_name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('zip_code')
                            ->required()
                            ->maxLength(5),
                        DatePicker::make('birth_date')
                            ->before(now())
                            ->required(),
                        DatePicker::make('hired_date')
                            ->default(now())
                            ->required(),
                        TextInput::make('phone_number')
                            ->prefix('+93'),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email(),
                        Textarea::make('address')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
