<?php

namespace App\Filament\Resources\Countries\RelationManagers;

use App\Filament\Resources\Employees\EmployeeResource;
use App\Models\Employee;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('state_id')
                    ->required()
                    ->numeric(),
                TextInput::make('city_id')
                    ->required()
                    ->numeric(),
                TextInput::make('department_id')
                    ->required()
                    ->numeric(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('address')
                    ->required(),
                TextInput::make('zip_code')
                    ->required(),
                DatePicker::make('birth_date')
                    ->required(),
                DatePicker::make('hired_date')
                    ->required(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('state_id')
                    ->numeric(),
                TextEntry::make('city_id')
                    ->numeric(),
                TextEntry::make('department_id')
                    ->numeric(),
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('address'),
                TextEntry::make('zip_code'),
                TextEntry::make('birth_date')
                    ->date(),
                TextEntry::make('hired_date')
                    ->date(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn(Employee $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('state.name')
                    ->sortable(),
                TextColumn::make('city.name')
                    ->sortable(),
                TextColumn::make('department.name')
                    ->sortable(),
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('zip_code')
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('hired_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                Action::make('createEmployee')
                    ->label('Create Employee')
                    ->url(EmployeeResource::getUrl('create', [
                        'country_id' => $this->ownerRecord->id,
                    ])),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn($record) => EmployeeResource::getUrl('view', [
                        'record' => $record,
                    ])),
                Action::make('editEmployee')
                    ->label('Edit Employee')
                    ->url(fn($record) => EmployeeResource::getUrl('edit', [
                        'record' => $record,
                    ])),
                DissociateAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
