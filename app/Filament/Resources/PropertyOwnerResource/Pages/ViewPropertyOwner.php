<?php

namespace App\Filament\Resources\PropertyOwnerResource\Pages;

use App\Filament\Resources\PropertyOwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPropertyOwner extends ViewRecord
{
    protected static string $resource = PropertyOwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
