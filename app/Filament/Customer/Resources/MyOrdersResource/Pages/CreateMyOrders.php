<?php

namespace App\Filament\Customer\Resources\MyOrdersResource\Pages;

use App\Filament\Customer\Resources\MyOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMyOrders extends CreateRecord
{
    protected static string $resource = MyOrdersResource::class;
}
