<?php

namespace App\Filament\Resources\CityResource\Pages;

use App\Filament\Resources\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCities extends ListRecords
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New City')
                ->modalHeading('Create New City')
                ->modalDescription('Fill in the details to create a new city.')
                ->modalSubmitActionLabel('Create City')
                ->modalCancelActionLabel('Cancel'),
        ];
    }
}
