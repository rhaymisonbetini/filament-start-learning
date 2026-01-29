<?php

namespace App\Filament\Resources\Students\Widgets;

use Filament\Widgets\ChartWidget;

class StudentRegistrationChart extends ChartWidget
{
    protected ?string $heading = 'Student Registration';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Student Registrations',
                    'data' => [5, 8, 12, 6, 10, 7, 9, 11, 5, 8, 4, 6],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
