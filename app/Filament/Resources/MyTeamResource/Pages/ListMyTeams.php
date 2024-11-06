<?php

namespace App\Filament\Resources\MyTeamResource\Pages;

use App\Filament\Resources\MyTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMyTeams extends ListRecords
{
    protected static string $resource = MyTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
