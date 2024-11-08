<?php

namespace App\Filament\Resources\MajorResource\Widgets;

use App\Models\Major;
use Filament\Widgets\ChartWidget;

class MajorChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Majors';

    protected static ?string $description = 'Major distribution.';

    protected int | string | array $columnSpan = '1';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $majors = Major::all();
        $labels = $majors->pluck('name')->toArray();
        $data = $majors->map(fn($major) => $major->students()->count())->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Students per Major',
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