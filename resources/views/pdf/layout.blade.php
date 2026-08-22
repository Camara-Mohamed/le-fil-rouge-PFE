<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #1A1A2E;
            background: #ffffff;
            padding: 0;
        }

        /* Header */
        .pdf-header {
            background-color: #C1121F;
            padding: 20px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pdf-header-name {
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .pdf-header-meta {
            color: rgba(255,255,255,0.8);
            font-size: 10px;
            text-align: right;
        }

        /* Content */
        .pdf-body {
            padding: 28px 32px;
        }

        .pdf-title {
            border-left: 4px solid #C1121F;
            padding: 8px 14px;
            margin-bottom: 24px;
            background-color: #FFF5F5;
        }

        .pdf-title h1 {
            font-size: 18px;
            font-weight: bold;
            color: #1A1A2E;
            margin-bottom: 2px;
        }

        .pdf-title p {
            font-size: 11px;
            color: #6A6A88;
        }

        /* Section */
        .pdf-section {
            margin-bottom: 22px;
        }

        .pdf-section-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #C1121F;
            border-bottom: 1px solid #EDE0DC;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        .pdf-info-row {
            display: flex;
            margin-bottom: 5px;
            font-size: 11px;
        }

        .pdf-info-label {
            color: #6A6A88;
            min-width: 130px;
            font-weight: bold;
        }

        .pdf-info-value {
            color: #1A1A2E;
        }

        /* Stats */
        .pdf-stats {
            display: flex;
            gap: 12px;
            margin-bottom: 22px;
        }

        .pdf-stat {
            flex: 1;
            background-color: #F8F5F0;
            border-radius: 6px;
            padding: 10px 14px;
            text-align: center;
        }

        .pdf-stat-value {
            font-size: 22px;
            font-weight: bold;
            color: #1A1A2E;
        }

        .pdf-stat-label {
            font-size: 9px;
            color: #6A6A88;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .pdf-stat.accepted .pdf-stat-value { color: #16a34a; }
        .pdf-stat.pending  .pdf-stat-value { color: #d97706; }
        .pdf-stat.refused  .pdf-stat-value { color: #C1121F; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        thead tr {
            background-color: #1A1A2E;
            color: #ffffff;
        }

        thead th {
            padding: 7px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr:nth-child(even) {
            background-color: #F8F5F0;
        }

        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tbody td {
            padding: 7px 10px;
            color: #1A1A2E;
            border-bottom: 1px solid #EDE0DC;
        }

        /* Footer */
        .pdf-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 8px 32px;
            background-color: #F8F5F0;
            border-top: 2px solid #EDE0DC;
            font-size: 9px;
            color: #6A6A88;
            display: flex;
            justify-content: space-between;
        }

        .page-number::after {
            content: counter(page);
        }
    </style>
</head>
<body>

    <div class="pdf-header">
        <span class="pdf-header-name">{{ config('app.name') }}</span>
        <div class="pdf-header-meta">
            Généré le {{ now()->format('d/m/Y à H:i') }}
        </div>
    </div>

    <div class="pdf-body">
        @yield('content')
    </div>

    <div class="pdf-footer">
        <span>{{ config('app.name') }} - Document confidentiel</span>
        <span>{{ __('pdf.page') }} <span class="page-number"></span></span>
    </div>

</body>
</html>
