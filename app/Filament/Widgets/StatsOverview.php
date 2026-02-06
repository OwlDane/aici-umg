<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Program;
use App\Models\ClassModel;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Total Pendaftaran
        $totalEnrollments = Enrollment::count();
        $pendingEnrollments = Enrollment::where('status', 'pending')->count();
        $confirmedEnrollments = Enrollment::where('status', 'confirmed')->count();
        
        // Total Pembayaran
        $totalRevenue = Payment::where('status', 'paid')->sum('total_amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        
        // Total Program & Kelas
        $totalPrograms = Program::where('is_active', true)->count();
        $totalClasses = ClassModel::where('is_active', true)->count();
        
        return [
            Stat::make('Total Pendaftaran', $totalEnrollments)
                ->description($pendingEnrollments . ' menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('primary')
                ->chart([7, 12, 15, 18, 22, 25, $totalEnrollments]),
            
            Stat::make('Pendaftaran Aktif', $confirmedEnrollments)
                ->description('Siswa terkonfirmasi')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description($pendingPayments . ' pembayaran pending')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([100000, 250000, 500000, 750000, 1000000, $totalRevenue]),
            
            Stat::make('Program Aktif', $totalPrograms)
                ->description($totalClasses . ' kelas tersedia')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
        ];
    }
}
