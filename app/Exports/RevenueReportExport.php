<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class RevenueReportExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $dateFrom;
    protected $dateTo;
    protected $status;

    public function __construct($dateFrom = null, $dateTo = null, $status = null)
    {
        $this->dateFrom = $dateFrom ?? Carbon::now()->startOfMonth();
        $this->dateTo = $dateTo ?? Carbon::now()->endOfMonth();
        $this->status = $status;
    }

    public function query()
    {
        $query = Payment::query()
            ->with(['enrollment.user', 'enrollment.class'])
            ->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Invoice Number',
            'Student Name',
            'Class',
            'Amount',
            'Admin Fee',
            'Total Amount',
            'Payment Method',
            'Status',
            'Created At',
            'Paid At',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->invoice_number,
            $payment->enrollment->user->full_name ?? 'N/A',
            $payment->enrollment->class->name ?? 'N/A',
            'Rp ' . number_format($payment->amount, 0, ',', '.'),
            'Rp ' . number_format($payment->admin_fee, 0, ',', '.'),
            'Rp ' . number_format($payment->total_amount, 0, ',', '.'),
            strtoupper($payment->payment_method),
            ucfirst($payment->status),
            $payment->created_at->format('Y-m-d H:i:s'),
            $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : '-',
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
        return 'Revenue Report';
    }
}
