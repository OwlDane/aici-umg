<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enrollment Report</title>
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
            font-size: 10px;
        }
        th {
            background: #255d74;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 6px;
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
        <h1>ENROLLMENT REPORT</h1>
        <p>Period: {{ $dateFrom->format('d M Y') }} - {{ $dateTo->format('d M Y') }}</p>
        <p>Generated: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Enrollments:</span> {{ $summary['total'] }}
        </div>
        <div class="summary-item">
            <span class="summary-label">Confirmed:</span> {{ $summary['confirmed'] }}
        </div>
        <div class="summary-item">
            <span class="summary-label">Pending:</span> {{ $summary['pending'] }}
        </div>
        <div class="summary-item">
            <span class="summary-label">Cancelled:</span> {{ $summary['cancelled'] }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Enrollment #</th>
                <th>Student</th>
                <th>Email</th>
                <th>Class</th>
                <th>Level</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $enrollment)
            <tr>
                <td>{{ $enrollment->enrollment_number }}</td>
                <td>{{ $enrollment->student_name }}</td>
                <td>{{ $enrollment->student_email }}</td>
                <td>{{ $enrollment->class->name ?? 'N/A' }}</td>
                <td>{{ $enrollment->class->level ?? 'N/A' }}</td>
                <td>{{ ucfirst($enrollment->status) }}</td>
                <td>{{ $enrollment->enrolled_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} AICI - Artificial Intelligence Center Indonesia</p>
    </div>
</body>
</html>
