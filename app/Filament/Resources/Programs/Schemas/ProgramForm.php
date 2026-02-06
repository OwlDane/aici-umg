<?php

namespace App\Filament\Resources\Programs\Schemas;

use App\Enums\EducationLevel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Program')
                    ->description('Informasi dasar tentang program')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Program')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL-friendly version dari nama program'),
                        
                        Select::make('education_level')
                            ->label('Tingkat Pendidikan')
                            ->required()
                            ->options(EducationLevel::class)
                            ->native(false),
                        
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        
                        Textarea::make('objectives')
                            ->label('Tujuan Pembelajaran')
                            ->helperText('Pisahkan setiap tujuan dengan enter (JSON array)')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('Media')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar Program')
                            ->image()
                            ->directory('programs')
                            ->maxSize(2048)
                            ->helperText('Maksimal 2MB'),
                    ]),
                
                Section::make('Persyaratan')
                    ->description('Persyaratan usia dan durasi program')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('min_age')
                                    ->label('Usia Minimum')
                                    ->numeric()
                                    ->minValue(5)
                                    ->maxValue(100)
                                    ->suffix('tahun'),
                                
                                TextInput::make('max_age')
                                    ->label('Usia Maksimum')
                                    ->numeric()
                                    ->minValue(5)
                                    ->maxValue(100)
                                    ->suffix('tahun'),
                                
                                TextInput::make('duration_weeks')
                                    ->label('Durasi')
                                    ->numeric()
                                    ->minValue(1)
                                    ->suffix('minggu'),
                            ]),
                    ]),
                
                Section::make('Pengaturan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true)
                                    ->helperText('Program aktif akan ditampilkan di website'),
                                
                                TextInput::make('sort_order')
                                    ->label('Urutan Tampilan')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Semakin kecil angka, semakin atas posisinya'),
                            ]),
                    ]),
            ]);
    }
}
