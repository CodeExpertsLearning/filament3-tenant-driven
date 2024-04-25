<?php

namespace App\Filament\Pages;

use App\Models\Store;
use Filament\Forms;
use Filament\Pages\Dashboard as DashboardFilament;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends DashboardFilament
{
    use HasFiltersForm;

    public function filtersForm(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('store_id')->options(
                fn () => Store::pluck('name', 'id')
            ),
            Forms\Components\DatePicker::make('startDate'),
            Forms\Components\DatePicker::make('endDate')

        ]);
    }
}
