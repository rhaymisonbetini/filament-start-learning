<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('class_id')
                    ->name('Class')
                    ->live()
                    ->relationship('classes', 'name')
                    ->required(),
                Select::make('section_id')
                    ->name('Section')
                    ->options(function ($get) {
                        $classId = $get('class_id');
                        if ($classId) {
                            return Section::query()
                                ->where('class_id', $classId)
                                ->pluck('name', 'id')
                                ->toArray();
                        }
                        return [];
                    })
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Toggle::make('active')
                    ->label('Active')
                    ->required(),
            ]);
    }
}
