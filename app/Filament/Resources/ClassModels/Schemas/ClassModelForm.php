<?php

namespace App\Filament\Resources\ClassModels\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClassModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('program_id')
                    ->relationship('program', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('level')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('curriculum')
                    ->columnSpanFull(),
                Textarea::make('prerequisites')
                    ->columnSpanFull(),
                TextInput::make('min_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('min_age')
                    ->numeric(),
                TextInput::make('max_age')
                    ->numeric(),
                TextInput::make('duration_hours')
                    ->numeric(),
                TextInput::make('total_sessions')
                    ->numeric(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('capacity')
                    ->required()
                    ->numeric()
                    ->default(20),
                TextInput::make('enrolled_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                FileUpload::make('image')
                    ->image(),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('created_by')
                    ->numeric(),
                TextInput::make('updated_by')
                    ->numeric(),
            ]);
    }
}
