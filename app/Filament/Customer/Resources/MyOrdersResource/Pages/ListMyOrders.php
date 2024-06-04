<?php

namespace App\Filament\Customer\Resources\MyOrdersResource\Pages;

use App\Filament\Customer\Resources\MyOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListMyOrders extends ListRecords
{
    protected static string $resource = MyOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
