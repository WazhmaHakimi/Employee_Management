<?php

namespace App\Filament\Resources\CityResource\Pages;

use App\Filament\Resources\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCity extends EditRecord
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Delete City')
                ->modalDescription('Are you sure you want to delete this city? This action cannot be undone.')
                ->modalSubmitActionLabel('Yes, delete it')
                ->modalCancelActionLabel('Cancel'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
