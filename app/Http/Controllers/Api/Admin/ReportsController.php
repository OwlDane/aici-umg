<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Exports\RevenueReportExport;
use App\Exports\EnrollmentReportExport;
use App\Exports\StudentReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\User;
use App\Enums\UserRole;

class ReportsController extends Controller
{
    /**
     * Get report summary
     */
    public function summary(Request $request)
    {
        $dateFrom = $request->input('date_from') 
            ? Carbon::parse($request->input('date_from'))->startOfDay()
            : Carbon::now()->startOfMonth();
        
        $dateTo = $request->input('date_to')
            ? Carbon::parse($request->input('date_to'))->endOfDay()
            : Carbon::now()->endOfMonth();

        // Revenue summary
        $revenue = Payment::where('status', 'paid')
            ->whereBetween('paid_at', [$dateFrom, $dateTo])
            ->selectRaw('
                COUNT(*) as total_transactions,
                SUM(amount) as total_revenue,
                SUM(admin_fee) as total_admin_fee,
                AVG(amount) as avg_transaction
            ')
            ->first();

        // Enrollment summary
        $enrollments = Enrollment::whereBetween('enrolled_at', [$dateFrom, $dateTo])
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "confirmed" THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled
            ')
            ->first();

        // Student summary
        $students = User::where('role', UserRole::STUDENT)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        return response()->json([
            'period' => [
                'from' => $dateFrom->format('Y-m-d'),
                'to' => $dateTo->format('Y-m-d'),
            ],
            'revenue' => [
                'total_transactions' => $revenue->total_transactions ?? 0,
                'total_revenue' => (float) ($revenue->total_revenue ?? 0),
                'total_admin_fee' => (float) ($revenue->total_admin_fee ?? 0),
                'avg_transaction' => (float) ($revenue->avg_transaction ?? 0),
            ],
            'enrollments' => [
                'total' => $enrollments->total ?? 0,
                'confirmed' => $enrollments->confirmed ?? 0,
                'pending' => $enrollments->pending ?? 0,
                'cancelled' => $enrollments->cancelled ?? 0,
            ],
            'students' => [
                'new_registrations' => $students,
            ],
        ]);
    }

    /**
     * Export revenue report
     */
    public function exportRevenue(Request $request)
    {
        $dateFrom = $request->input('date_from') 
            ? Carbon::parse($request->input('date_from'))->startOfDay()
            : Carbon::now()->startOfMonth();
        
        $dateTo = $request->input('date_to')
            ? Carbon::parse($request->input('date_to'))->endOfDay()
            : Carbon::now()->endOfMonth();

        $status = $request->input('status');
        $format = $request->input('format', 'xlsx');

        $filename = 'revenue_report_' . $dateFrom->format('Ymd') . '_' . $dateTo->format('Ymd');

        if ($format === 'pdf') {
            return $this->exportRevenuePDF($dateFrom, $dateTo, $status, $filename);
        }

        return Excel::download(
            new RevenueReportExport($dateFrom, $dateTo, $status),
            $filename . '.xlsx'
        );
    }

    /**
     * Export enrollment report
     */
    public function exportEnrollment(Request $request)
    {
        $dateFrom = $request->input('date_from') 
            ? Carbon::parse($request->input('date_from'))->startOfDay()
            : Carbon::now()->startOfMonth();
        
        $dateTo = $request->input('date_to')
            ? Carbon::parse($request->input('date_to'))->endOfDay()
            : Carbon::now()->endOfMonth();

        $status = $request->input('status');
        $level = $request->input('level');
        $format = $request->input('format', 'xlsx');

        $filename = 'enrollment_report_' . $dateFrom->format('Ymd') . '_' . $dateTo->format('Ymd');

        if ($format === 'pdf') {
            return $this->exportEnrollmentPDF($dateFrom, $dateTo, $status, $level, $filename);
        }

        return Excel::download(
            new EnrollmentReportExport($dateFrom, $dateTo, $status, $level),
            $filename . '.xlsx'
        );
    }

    /**
     * Export student report
     */
    public function exportStudent(Request $request)
    {
        $dateFrom = $request->input('date_from') 
            ? Carbon::parse($request->input('date_from'))->startOfDay()
            : Carbon::now()->startOfMonth();
        
        $dateTo = $request->input('date_to')
            ? Carbon::parse($request->input('date_to'))->endOfDay()
            : Carbon::now()->endOfMonth();

        $format = $request->input('format', 'xlsx');
        $filename = 'student_report_' . $dateFrom->format('Ymd') . '_' . $dateTo->format('Ymd');

        if ($format === 'pdf') {
            return $this->exportStudentPDF($dateFrom, $dateTo, $filename);
        }

        return Excel::download(
            new StudentReportExport($dateFrom, $dateTo),
            $filename . '.xlsx'
        );
    }

    /**
     * Export revenue report as PDF
     */
    private function exportRevenuePDF($dateFrom, $dateTo, $status, $filename)
    {
        $query = Payment::query()
            ->with(['enrollment.user', 'enrollment.class'])
            ->whereBetween('created_at', [$dateFrom, $dateTo]);

        if ($status) {
            $query->where('status', $status);
        }

        $payments = $query->orderBy('created_at', 'desc')->get();

        $summary = [
            'total_transactions' => $payments->count(),
            'total_revenue' => $payments->where('status', 'paid')->sum('amount'),
            'total_admin_fee' => $payments->where('status', 'paid')->sum('admin_fee'),
        ];

        $pdf = Pdf::loadView('reports.revenue', [
            'payments' => $payments,
            'summary' => $summary,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);

        return $pdf->download($filename . '.pdf');
    }

    /**
     * Export enrollment report as PDF
     */
    private function exportEnrollmentPDF($dateFrom, $dateTo, $status, $level, $filename)
    {
        $query = Enrollment::query()
            ->with(['user', 'class', 'schedule'])
            ->whereBetween('enrolled_at', [$dateFrom, $dateTo]);

        if ($status) {
            $query->where('status', $status);
        }

        if ($level) {
            $query->whereHas('class', function ($q) use ($level) {
                $q->where('level', $level);
            });
        }

        $enrollments = $query->orderBy('enrolled_at', 'desc')->get();

        $summary = [
            'total' => $enrollments->count(),
            'confirmed' => $enrollments->where('status', 'confirmed')->count(),
            'pending' => $enrollments->where('status', 'pending')->count(),
            'cancelled' => $enrollments->where('status', 'cancelled')->count(),
        ];

        $pdf = Pdf::loadView('reports.enrollment', [
            'enrollments' => $enrollments,
            'summary' => $summary,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);

        return $pdf->download($filename . '.pdf');
    }

    /**
     * Export student report as PDF
     */
    private function exportStudentPDF($dateFrom, $dateTo, $filename)
    {
        $students = User::query()
            ->where('role', UserRole::STUDENT)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->withCount(['enrollments', 'testAttempts'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('reports.student', [
            'students' => $students,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);

        return $pdf->download($filename . '.pdf');
    }
}
