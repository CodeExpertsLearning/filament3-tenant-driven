<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CardDashBoardCount extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total de Clientes', 1000)
                //->chart([10, 250, 550])
                ->icon('heroicon-m-users')
                ->description('Clientes ao longo do ano'),
            //->descriptionIcon('heroicon-o-users')
            //->descriptionColor('success'),
            Stat::make('Total de Pedidos', 6)
        ];
    }
}
