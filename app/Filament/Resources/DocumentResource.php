<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Tenant;
use App\Models\Document;
use App\Models\Property;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DocumentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DocumentResource\RelationManagers;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Others';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tenant_id')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(function () {
                        return Tenant::with('user')->get()->pluck('user.name', 'id')->toArray();
                    }),
                Forms\Components\Select::make('property_id')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(function () {
                        return Property::all()->pluck('name', 'id');
                    }),
                Forms\Components\Select::make('uploaded_by')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(function () {
                        return User::all()->pluck('name', 'id');
                    }),
                Forms\Components\TextInput::make('document_type')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('file_path')
                    ->required()
                    ->preserveFilenames()
                    ->multiple()
                    ->reorderable()
                    ->previewable()
                    ->downloadable()
                    ->acceptedFileTypes(['image/*', 'application/pdf']),
                Forms\Components\DatePicker::make('upload_date')->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tenant.user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('property.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('uploadedByUser.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_type')
                    ->searchable(),
                ImageColumn::make('file_path')
                ,
                Tables\Columns\TextColumn::make('upload_date')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
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
