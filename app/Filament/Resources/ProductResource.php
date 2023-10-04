<?php

namespace App\Filament\Resources;

use App\Enums\ProducTypeEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
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
                        Section::make('Dados Primordiais')
                            ->description('preencha todos os campos')
                            ->schema([
                                TextInput::make('name')->required()->live(onBlur: true)->unique()->afterStateUpdated(function(string $operation,$state,Set $set){
                                    if($operation!=='create'){
                                        return;
                                    }
                                    $set('slug',Str::slug($state));
                                }),
                                TextInput::make('slug')->required()->dehydrated()->disabled()->unique(Product::class,'slug',ignoreRecord:true),
                                MarkdownEditor::make('description')->columnSpan('full'),
                            ])
                            ->columns(2),
                        Group::make(
                            schema: [
                                Section::make('Price & Inventory')
                                    ->description('preencha todos os campos')
                                    ->schema([
                                        TextInput::make('sku')->label('sku(stock keeping unit)')->unique()->required(),
                                        TextInput::make('price')->numeric(),
                                        TextInput::make('quantity')->numeric(),
                                        Select::make('type')->options([
                                            'deliverable' => ProducTypeEnum::DELIVERABLE->value,
                                            'downloadable' => ProducTypeEnum::DOWNLOADABLE->value
                                        ])->required()
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
                                Toggle::make('is_visible')->label('visibility')->helperText('enable or disable text visibility')->default(true),
                                Toggle::make('is_featured'),
                                DatePicker::make('published_at')->label('avaiability')->default(now()),
                            ])
                            ->columns(2),
                        Section::make('image')->schema([
                            FileUpload::make('image')->image()->imageEditor(),
                        ])->collapsible(),
                        Section::make('relashionsips')->schema([
                            Select::make('brand_id')->relationship('brand', 'name')
                        ])
                    ]
                )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('brand.name')->searchable()->sortable()->toggleable(),
                IconColumn::make('is_visible')->boolean(),
                TextColumn::make('price'),
                TextColumn::make('quantity'),
                TextColumn::make('published_at')->date(),
                TextColumn::make('type'),
            ])
            ->filters([
                SelectFilter::make('brand')->relationship('brand','name')
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
