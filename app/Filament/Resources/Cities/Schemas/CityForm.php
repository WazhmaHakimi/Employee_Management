<?php

namespace App\Filament\Resources\Cities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('City Information')
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
}
