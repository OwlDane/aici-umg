<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Revenue Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #255d74;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #255d74;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .summary {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .summary-item {
            display: inline-block;
            width: 48%;
            margin-bottom: 10px;
        }
        .summary-label {
            font-weight: bold;
            color: #255d74;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #255d74;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REVENUE REPORT</h1>
        <p>Period: {{ $dateFrom->format('d M Y') }} - {{ $dateTo->format('d M Y') }}</p>
        <p>Generated: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Transactions:</span> {{ $summary['total_transactions'] }}
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Revenue:</span> Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Admin Fee:</span> Rp {{ number_format($summary['total_admin_fee'], 0, ',', '.') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Student</th>
                <th>Class</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->invoice_number }}</td>
                <td>{{ $payment->enrollment->user->full_name ?? 'N/A' }}</td>
                <td>{{ $payment->enrollment->class->name ?? 'N/A' }}</td>
                <td>Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                <td>{{ ucfirst($payment->status) }}</td>
                <td>{{ $payment->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} AICI - Artificial Intelligence Center Indonesia</p>
    </div>
</body>
</html>
