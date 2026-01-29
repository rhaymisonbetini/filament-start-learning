<?php

namespace App\Filament\Resources\Students\Widgets;

use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    /**
     * @return array|Stat[]
     */
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', Student::query()->count()),
            Stat::make('Active Students', Student::query()->where('active', true)->count()),
            Stat::make('Inactive Students', Student::query()->where('active', false)->count()),
        ];
    }
}
