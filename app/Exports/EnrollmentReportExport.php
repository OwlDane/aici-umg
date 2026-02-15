<?php

namespace App\Exports;

use App\Models\Enrollment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class EnrollmentReportExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $dateFrom;
    protected $dateTo;
    protected $status;
    protected $level;

    public function __construct($dateFrom = null, $dateTo = null, $status = null, $level = null)
    {
        $this->dateFrom = $dateFrom ?? Carbon::now()->startOfMonth();
        $this->dateTo = $dateTo ?? Carbon::now()->endOfMonth();
        $this->status = $status;
        $this->level = $level;
    }

    public function query()
    {
        $query = Enrollment::query()
            ->with(['user', 'class', 'schedule'])
            ->whereBetween('enrolled_at', [$this->dateFrom, $this->dateTo]);

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->level) {
            $query->whereHas('class', function ($q) {
                $q->where('level', $this->level);
            });
        }

        return $query->orderBy('enrolled_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Enrollment Number',
            'Student Name',
            'Email',
            'Phone',
            'Age',
            'Class',
            'Level',
            'Schedule',
            'Status',
            'Enrolled At',
            'Confirmed At',
        ];
    }

    public function map($enrollment): array
    {
        return [
            $enrollment->enrollment_number,
            $enrollment->student_name,
            $enrollment->student_email,
            $enrollment->student_phone,
            $enrollment->student_age,
            $enrollment->class->name ?? 'N/A',
            $enrollment->class->level ?? 'N/A',
            $enrollment->schedule ? $enrollment->schedule->batch_name : 'N/A',
            ucfirst($enrollment->status),
            $enrollment->enrolled_at->format('Y-m-d H:i:s'),
            $enrollment->confirmed_at ? $enrollment->confirmed_at->format('Y-m-d H:i:s') : '-',
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
        return 'Enrollment Report';
    }
}
