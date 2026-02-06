<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class EnrollmentChart extends ChartWidget
{
    protected ?string $heading = 'Pendaftaran Per Bulan';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Get enrollment data for last 6 months
        $data = [];
        $labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');
            
            $count = Enrollment::whereYear('enrolled_at', $month->year)
                ->whereMonth('enrolled_at', $month->month)
                ->count();
            
            $data[] = $count;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Pendaftaran',
                    'data' => $data,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
