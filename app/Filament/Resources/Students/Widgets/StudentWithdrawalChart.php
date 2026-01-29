<?php

namespace App\Filament\Resources\Students\Widgets;

use Filament\Widgets\ChartWidget;

class StudentWithdrawalChart extends ChartWidget
{
    protected ?string $heading = 'Student Withdrawal';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Student Withdrawal',
                    'data' => [2, 4, 6, 3, 8, 5, 4, 7, 3, 5, 2, 4],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
