<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationGroup = 'Shop';
    protected static ?string $navigationLabel = 'Produtos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make(
                    schema: [
                        Section::make('Dados Pessoais')
                            ->description('preencha todos os campos')
                            ->schema([
                                TextInput::make('name'),
                                TextInput::make('slug'),
                                MarkdownEditor::make('description')->columnSpan('full'),
                            ])
                            ->columns(2),
                        Group::make(
                            schema: [
                                Section::make('Price & Inventory')
                                    ->description('preencha todos os campos')
                                    ->schema([
                                        
                                    ])
                                    ->columns(2),
                            ]
                        ),
                    ],

                ),
                Group::make(
                    schema: [
                        Section::make('Status')
                            ->description('preencha todos os campos')
                            ->schema([
                                Toggle::make('is_visible'),
                                Toggle::make('is_featured'),
                                DatePicker::make('published_at'),
                            ])
                            ->columns(2),
                    ]
                )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('name'),
                TextColumn::make('brand.name'),
                IconColumn::make('is_visible')->boolean(),
                TextColumn::make('price'),
                TextColumn::make('quantity'),
                TextColumn::make('published_at'),
                TextColumn::make('type'),
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
}
