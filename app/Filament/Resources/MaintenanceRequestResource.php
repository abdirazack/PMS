<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Tenant;
use App\Models\Property;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\MaintenanceRequest;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MaintenanceRequestResource\Pages;
use App\Filament\Resources\MaintenanceRequestResource\RelationManagers;

class MaintenanceRequestResource extends Resource
{
    protected static ?string $model = MaintenanceRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Others';

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tenant_id')->options(
                    Tenant::all()->pluck('user_id', 'id')
                    // get the user name using the user_id
                    // User::all()->pluck('name', Tenant::all()->pluck('user_id', 'id'))
                )->native(false)->required(),

                Select::make('property_id')->options(
                    Property::all()->pluck('name', 'id')
                )->native(false)->required()->label('Property'),

                Select::make('assigned_to')->options(
                    User::all()->pluck('name', 'id')
                )->native(false)->required(),

                Select::make('priority')->options(
                    ['low', 'medium', 'high']
                )->native(false)->required(),

                Forms\Components\DatePicker::make('request_date')->native(false)->label('Request Date'),
                Forms\Components\DatePicker::make('completion_date')->native(false)->label('Completion Date'),

                Select::make('status')->options(
                    [
                        'pending' => 'pending',
                        'completed' => 'completed',
                        'in progress'   => 'in progress',
                        'cancelled' => 'cancelled',
                        'rejected' => 'rejected',
                    ]
                )->native(false)->required(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tenant_id')
                    // ->numeric()
                    ->sortable()
                    ->label('Tenant'),
                Tables\Columns\TextColumn::make('property.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assigned_to')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('priority')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completion_date')
                    ->date()
                    ->sortable()
                    ->label('Completion Date'),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'info',
                        'in progress' => 'primary',
                        'cancelled' => 'gray',
                        'reviewing' => 'warning',
                        'completed' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListMaintenanceRequests::route('/'),
            'create' => Pages\CreateMaintenanceRequest::route('/create'),
            'view' => Pages\ViewMaintenanceRequest::route('/{record}'),
            'edit' => Pages\EditMaintenanceRequest::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
