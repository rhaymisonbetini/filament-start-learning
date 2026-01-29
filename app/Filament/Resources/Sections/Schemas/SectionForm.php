<?php

namespace App\Filament\Resources\Sections\Schemas;

use App\Models\Classes;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('class_id')
                    ->name("Class")
                    ->relationship('classes', 'name'),
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
