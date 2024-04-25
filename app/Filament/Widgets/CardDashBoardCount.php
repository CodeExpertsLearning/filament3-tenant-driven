<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Facades\Filament;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CardDashBoardCount extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 1;

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total de Clientes', Filament::getTenant()->members->count()) // nos vamos pegar apenas os users Clientes
                //->chart([10, 250, 550])
                ->icon('heroicon-m-users')
                ->description('Clientes ao longo do ano'),
            //->descriptionIcon('heroicon-o-users')
            //->descriptionColor('success'),
            Stat::make('Total de Pedidos', $this->loadOrdersFiltersAndQuery()->count())
        ];
    }

    private function loadOrdersFiltersAndQuery()
    {
        return Order::loadWithTenant()
            ->when($this->filters['store_id'], fn ($query) => $query->whereStoreId($this->filters['store_id']))
            ->when($this->filters['startDate'], fn ($query) => $query->whereCreatedAt('>', $this->filters['startDate']))
            ->when($this->filters['endDate'], fn ($query) => $query->whereCreatedAt('<', $this->filters['endDate']));
    }
}
