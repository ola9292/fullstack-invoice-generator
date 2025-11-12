<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $data['invoice_number'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 0;
        }
        .header {
            background-color: #212529;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 40px;
        }
        .invoice-header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .invoice-header-left,
        .invoice-header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .invoice-header-right {
            text-align: right;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        .invoice-number {
            color: #666;
            margin: 0;
        }
        .party-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .from-info,
        .to-info {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 15px;
            background-color: #f9f9f9;
        }
        .from-info {
            border-right: 1px solid #e0e0e0;
        }
        .party-label {
            font-weight: bold;
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .party-name {
            font-weight: bold;
            font-size: 16px;
            margin: 5px 0;
        }
        .party-email {
            color: #666;
            margin: 5px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table thead {
            background-color: #212529;
            color: #ffffff;
        }
        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .items-table th {
            font-weight: bold;
        }
        .items-table tbody tr:hover {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .totals-section {
            display: table;
            width: 100%;
            margin-top: 20px;
        }
        .totals-left {
            display: table-cell;
            width: 50%;
        }
        .totals-right {
            display: table-cell;
            width: 50%;
        }
        .totals-table {
            width: 100%;
            margin-left: auto;
        }
        .totals-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .totals-table tr:last-child td {
            border-bottom: 2px solid #212529;
            font-weight: bold;
            font-size: 18px;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
        }
        @media only screen and (max-width: 600px) {
            .invoice-header-left,
            .invoice-header-right,
            .from-info,
            .to-info,
            .totals-left,
            .totals-right {
                display: block;
                width: 100%;
            }
            .from-info {
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
            }
            .invoice-header-right {
                text-align: left;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Content -->
        <div class="content">
            <!-- Invoice Header -->
            <div class="invoice-header">
                <div class="invoice-header-left">
                    <p class="invoice-title">INVOICE</p>
                    <p class="invoice-number">{{ $data['invoice_number'] }}</p>
                </div>
                <div class="invoice-header-right">
                    <p><strong>Date:</strong> {{ date('F d, Y', strtotime($data['date'])) }}</p>
                </div>
            </div>

            <!-- From/To Information -->
            <div class="party-info">
                <div class="from-info">
                    <div class="party-label">FROM:</div>
                    <div class="party-name">{{ $data['from_name'] }}</div>
                    <div class="party-email">{{ $data['from_email'] }}</div>
                </div>
                <div class="to-info">
                    <div class="party-label">TO:</div>
                    <div class="party-name">{{ $data['to_name'] }}</div>
                    <div class="party-email">{{ $data['to_email'] }}</div>
                </div>
            </div>

            <!-- Items Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Rate</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['items'] as $item)
                    <tr>
                        <td>{{ $item['description'] }}</td>
                        <td class="text-right">{{ $item['quantity'] }}</td>
                        <td class="text-right">${{ number_format($item['rate'], 2) }}</td>
                        <td class="text-right">${{ number_format($item['amount'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals Section -->
            <div class="totals-section">
                <div class="totals-left"></div>
                <div class="totals-right">
                    <table class="totals-table">
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-right">${{ number_format($data['sub_total'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>Tax ({{ $data['tax_rate'] }}%)</td>
                            <td class="text-right">${{ number_format($data['tax_amount'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>Discount ({{ $data['discount_rate'] }}%)</td>
                            <td class="text-right">-${{ number_format($data['discount_amount'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td class="text-right">${{ number_format($data['total_amount'], 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>If you have any questions about this invoice, please contact {{ $data['from_email'] }}</p>
        </div>
    </div>
</body>
</html>