<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DepartmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Department Information')
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID'),
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('created_at')
                            ->label('Created At'),
                        TextEntry::make('updated_at')
                            ->label('Updated At'),
                    ])
                    ->columns(2),
            ]);
    }
}
