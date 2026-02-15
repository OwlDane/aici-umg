<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Report</title>
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
        <h1>STUDENT REPORT</h1>
        <p>Period: {{ $dateFrom->format('d M Y') }} - {{ $dateTo->format('d M Y') }}</p>
        <p>Generated: {{ now()->format('d M Y H:i:s') }}</p>
        <p>Total Students: {{ $students->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Enrollments</th>
                <th>Test Attempts</th>
                <th>Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->full_name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->phone ?? 'N/A' }}</td>
                <td>{{ $student->enrollments_count }}</td>
                <td>{{ $student->test_attempts_count }}</td>
                <td>{{ $student->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} AICI - Artificial Intelligence Center Indonesia</p>
    </div>
</body>
</html>
