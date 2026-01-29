<?php

namespace App\Filament\Resources\Students\Tables;

use App\Exports\StudentExport;
use App\Models\Classes;
use App\Models\Section;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Exports\Models\Export;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('classes.name')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('section.name')
                    ->badge()
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                IconColumn::make('active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('active')
                    ->label('Active')
                    ->query(fn(Builder $query): Builder => $query->where('active', true))
                    ->toggle(),

                Filter::make('Inatives')
                    ->label('Inatives')
                    ->query(fn(Builder $query): Builder => $query->where('active', false))
                    ->toggle(),


                Filter::make('class-section')
                    ->schema([
                        Select::make('class_id')
                            ->label('Class')
                            ->live()
                            ->options(fn(): array => Classes::query()->pluck('name', 'id')->all()),

                        Select::make('section_id')
                            ->label('Section')
                            ->options(function (Get $get) {
                                $classId = $get('class_id');
                                if ($classId) {
                                    return Section::query()->where('class_id', $classId)->pluck('name', 'id')->toArray();
                                }
                                return [];
                            }),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['class_id'] ?? null, function (Builder $query) use ($data) {
                            $query->where('class_id', $data['class_id'] ?? null);
                        })->when($data['section_id'] ?? null, function (Builder $query) use ($data) {
                            $query->where('section_id', $data['section_id'] ?? null);
                        });
                    }),

            ])
            ->recordActions([
                EditAction::make(),
                Action::make('download Pdf')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('Export')
                        ->label('Export to Excel')
                        ->icon(Heroicon::DocumentArrowDown)
                        ->action(function (Collection $records) {
                            return Excel::download(new StudentExport($records), 'students.xlsx');
                        })
                ]),
            ]);
    }
}
