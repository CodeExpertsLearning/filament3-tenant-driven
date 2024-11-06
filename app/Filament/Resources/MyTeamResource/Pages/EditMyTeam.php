<?php

namespace App\Filament\Resources\MyTeamResource\Pages;

use App\Filament\Resources\MyTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMyTeam extends EditRecord
{
    protected static string $resource = MyTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
