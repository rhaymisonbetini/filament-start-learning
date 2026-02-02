<?php

namespace App\Filament\Resources\Sections\Schemas;

use App\Models\Classes;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;

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
                    ->unique('sections', 'name', ignoreRecord: true, modifyRuleUsing: function (Get $get, Unique $rule) {
                        return $rule->where('class_id', $get('class_id'));
                    })
                    ->required(),
            ]);
    }
}
