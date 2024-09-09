<?php

namespace App\Filament\Resources\FicheResource\Pages;

use App\Filament\Resources\FicheResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFiche extends ViewRecord
{
    protected static string $resource = FicheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
