<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Models\Barang;
use App\Models\Gambar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required(),
                Forms\Components\TextInput::make('deskripsi')
                    ->required(),
                Forms\Components\TextInput::make('harga')
                    ->required(),
                Forms\Components\TextInput::make('stok')
                    ->required(),
                Forms\Components\FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->multiple()
                    ->directory('gambar')
                    ->disk('public')
                    ->maxFiles(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public')
                    ->getStateUsing(function (Barang $record) {
                        $firstGambar = $record->gambar->first();
                        return $firstGambar ? asset('storage/' . $firstGambar->path) : null;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M y')
                    ->sortable(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->handleGambarData($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->handleGambarData($data);
    }

    private function handleGambarData(array $data): array
    {
        $gambarPaths = $data['gambar'] ?? [];
        unset($data['gambar']);

        $barang = Barang::create($data);

        if ($barang && !empty($gambarPaths)) {
            $barang->saveGambar($gambarPaths);
        }

        return $data;
    }
}
