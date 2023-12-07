<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['price'] = number_format($data['price'], 2, ',', '.');

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['price'] =
            ((float) str_replace(['.', ','], ['', '.'], $data['price'])) * 100;

        return $data;
    }
}
