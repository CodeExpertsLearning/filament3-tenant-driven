<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MyTeamResource\Pages;
use App\Filament\Resources\MyTeamResource\RelationManagers;
use App\Models\MyTeam;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Password;

class MyTeamResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Membro';

    protected static ?string $pluralModelLabel = 'Membros';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?string $navigationLabel = 'Minha Equipe';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->rule(Password::default()),
                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->same('password')
                    ->rule(Password::default()),
                Forms\Components\Select::make('members')->relationship(
                    'tenants',
                    'name',
                    fn(Builder $query, Forms\Get $get) =>
                    $query->whereRelation(
                        'members',
                        'user_id',
                        '=',
                        auth()->id()
                    )
                )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->modifyQueryUsing(fn(Builder $query) => $query->whereRelation('tenants', 'tenant_id', Filament::getTenant()->id))
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at')->date('d/m/Y H:i:s'),
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
            'index' => Pages\ListMyTeams::route('/'),
            'create' => Pages\CreateMyTeam::route('/create'),
            'edit' => Pages\EditMyTeam::route('/{record}/edit'),
        ];
    }
}
