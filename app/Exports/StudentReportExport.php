<?php

namespace App\Exports;

use App\Models\User;
use App\Enums\UserRole;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class StudentReportExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $dateFrom;
    protected $dateTo;

    public function __construct($dateFrom = null, $dateTo = null)
    {
        $this->dateFrom = $dateFrom ?? Carbon::now()->startOfMonth();
        $this->dateTo = $dateTo ?? Carbon::now()->endOfMonth();
    }

    public function query()
    {
        return User::query()
            ->where('role', UserRole::STUDENT)
            ->whereBetween('created_at', [$this->dateFrom, $this->dateTo])
            ->withCount(['enrollments', 'testAttempts'])
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Email',
            'Phone',
            'Total Enrollments',
            'Total Test Attempts',
            'Registered At',
        ];
    }

    public function map($user): array
    {
        return [
            $user->full_name,
            $user->email,
            $user->phone ?? 'N/A',
            $user->enrollments_count,
            $user->test_attempts_count,
            $user->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Student Report';
    }
}
