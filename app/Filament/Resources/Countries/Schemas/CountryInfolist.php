<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CountryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Country Information')
                    ->schema([
                        TextEntry::make('country_code')
                            ->label('Country Code'),
                        TextEntry::make('name')
                            ->label('Country Name'),
                    ])
                    ->columns(2)
            ]);
    }
}
