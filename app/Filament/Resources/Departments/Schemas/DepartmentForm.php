<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Department Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
