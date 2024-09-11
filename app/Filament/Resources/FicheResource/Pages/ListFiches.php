<?php

namespace App\Filament\Resources\FicheResource\Pages;

use App\Filament\Resources\FicheResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListFiches extends ListRecords
{protected static ?string $navigationBadgeTooltip = 'The number of users';

    protected static string $resource = FicheResource::class;

    public function getTableRecordsPerPage(): int
    {
        return 50;
    }

public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}
    public function getTitle22(): string|Htmlable
    {
        return 'fiches';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
