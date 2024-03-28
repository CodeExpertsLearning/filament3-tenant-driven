<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LastCustomers extends BaseWidget
{
    protected static ?int $sort = 3;

    /**
     * @var int | string | array<string, int | null>
     */
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table->heading('10 últimos usuários registrados')
            ->query(
                fn () => \App\Models\User::latest()->take(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->date('d/M/Y')
            ]);
    }
}
