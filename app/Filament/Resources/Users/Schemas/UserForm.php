<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->password()
                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                            ->minLength(4)
                            ->same('passwordConfirmation')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                        TextInput::make('passwordConfirmation')
                            ->password()
                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                            ->minLength(4)
                            ->dehydrated(false),
                    ])
            ]);
    }
}
