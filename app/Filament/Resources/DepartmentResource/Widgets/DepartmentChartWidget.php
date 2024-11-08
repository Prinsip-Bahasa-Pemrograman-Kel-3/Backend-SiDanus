<?php

namespace App\Filament\Resources\DepartmentResource\Widgets;

use App\Models\Department;
use Filament\Widgets\ChartWidget;

class DepartmentChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Departments';

    protected static ?string $description = 'Department distribution.';

    protected int | string | array $columnSpan = '1';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $departments = Department::all();
        $labels = $departments->pluck('name')->toArray();
        $data = $departments->map(fn($department) => $department->majors()->count())->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Majors per Department',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}