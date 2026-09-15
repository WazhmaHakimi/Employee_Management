<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Employee;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Employee Information')
                    ->schema([
                        TextEntry::make('country.name')
                            ->label('Country'),
                        TextEntry::make('state.name')
                            ->label('State'),
                        TextEntry::make('city.name')
                            ->label('City'),
                        TextEntry::make('department.name')
                            ->label('Department'),
                        TextEntry::make('position.name')
                            ->label('Position'),
                        TextEntry::make('employment_type')
                            ->label('Employment Type')
                            ->formatStateUsing(fn(string $state): string => str_replace('_', ' ', ucfirst($state))),
                        TextEntry::make('first_name')
                            ->label('First Name'),
                        TextEntry::make('last_name')
                            ->label('Last Name'),
                        TextEntry::make('address')
                            ->label('Address'),
                        TextEntry::make('phone_number')
                            ->label('Phone Number'),
                        TextEntry::make('email')
                            ->label('Email Address'),
                        TextEntry::make('zip_code')
                            ->label('Zip Code'),
                        TextEntry::make('birth_date')
                            ->date()
                            ->label('Birth Date'),
                        TextEntry::make('hired_date')
                            ->date()
                            ->label('Hired Date'),
                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->visible(fn(Employee $record): bool => $record->trashed())
                            ->label('Deleted At'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-')
                            ->label('Created At'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-')
                            ->label('Updated At'),
                    ])
                    ->columns(2),
            ]);
    }
}
