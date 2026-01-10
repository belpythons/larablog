<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PostsChartWidget extends ChartWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function getHeading(): ?string
    {
        return 'Publishing Activity';
    }

    public function getMaxHeight(): ?string
    {
        return '300px';
    }

    protected function getData(): array
    {
        $data = collect(range(29, 0))->map(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo);
            return [
                'date' => $date->format('M d'),
                'count' => Post::whereDate('published_at', $date)->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Posts Published',
                    'data' => $data->pluck('count')->toArray(),
                    'borderColor' => '#facc15', // Brutal Yellow
                    'backgroundColor' => 'rgba(250, 204, 21, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $data->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
