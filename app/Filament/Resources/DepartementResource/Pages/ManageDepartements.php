<?php

namespace App\Filament\Resources\DepartementResource\Pages;

use App\Filament\Resources\DepartementResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDepartements extends ManageRecords
{
    protected static string $resource = DepartementResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
