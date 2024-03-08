<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?string $navigationLabel = 'Produtos';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $state = str()->of($state)->slug();

                        $set('slug', $state);
                    })
                    ->debounce(600)
                    ->required(),
                Forms\Components\Select::make('store_id')
                    ->relationship(
                        'store',
                        'name',
                        fn (Builder $query) =>
                        $query->whereRelation(
                            'tenant',
                            'tenant_id',
                            '=',
                            Filament::getTenant()->id
                        )
                    ),
                Forms\Components\TextInput::make('description'),
                Forms\Components\RichEditor::make('body')->required(),

                Forms\Components\Section::make('Dados Complementares')
                    ->columns(2)->schema([

                        Forms\Components\TextInput::make('price')->required(),
                        Forms\Components\Toggle::make('status')->required(),
                        Forms\Components\TextInput::make('stock')->required(),
                        Forms\Components\TextInput::make('slug')
                            ->required(),
                        Forms\Components\Select::make('categories')
                            ->multiple()
                            ->relationship(
                                'categories',
                                'name',
                                fn (Builder $query, Forms\Get $get) =>
                                $query->whereRelation(
                                    'tenant',
                                    'tenant_id',
                                    '=',
                                    Filament::getTenant()->id
                                )
                                    ->whereRelation(
                                        'store',
                                        'store_id',
                                        '=',
                                        $get('store_id')
                                    )
                            ),

                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Produto'),

                Tables\Columns\TextColumn::make('price')->money('BRL'),
                Tables\Columns\TextColumn::make('created_at')->date('d/m/Y H:i:s')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
