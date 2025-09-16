<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>تقرير الفواتير | LAXE ONLINE</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Tajawal', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: white;
            color: #333;
            padding: 0px;
        }

        @page {
            size: A4;
            margin: 15mm;
        }

        .main-report {
            width: 101%;
            margin: 0;
            margin-right: -10px;
            margin-left: -10px;
            background: white;
        }

        .report-header {
            padding: 1rem 0;
            text-align: center;
            border-bottom: 2px solid #1a5276;
            margin-bottom: 1.5rem;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #21007c;
        }

        .report-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #1a5276;
        }

        .report-content {
            padding: 0 10px;
        }

        .driver-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 1.5rem;
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            border-left: 4px solid #1a5276;
            font-size: 15px;
            color: #1a5276;
        }

        .info-box span {
            font-weight: 600;
            margin-right: 5px;
        }

        /* Table Styling */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            font-size: 16px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .invoice-table thead {
            display: table-header-group;
            /* Repeat header when printing */
        }

        .invoice-table thead tr {
            background: #1a5276;
            color: white;
            text-align: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .invoice-table th {
            padding: 20px 16px;
            /* bigger header cells */
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }

        .invoice-table th:not(:last-child)::after {
            content: "";
            position: absolute;
            left: 0;
            top: 25%;
            height: 50%;
            width: 1px;
            background: rgba(13, 45, 255, 0.3);
        }

        .invoice-table td {
            padding: 18px 14px;
            /* bigger body cells */
            text-align: center;
            border: 1px solid #e0e0e0;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #34495e;
            font-size: 15px;

        }

        /* Prevent breaking inside a row */
        .invoice-table tr {
            page-break-inside: avoid;
        }

        .invoice-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .invoice-table tr:hover {
            background-color: #eaf2f8;
        }

        .invoice-table td.address {
            font-weight: bold;
            text-align: right;
            white-space: normal;
            max-width: 200px;
        }

        .invoice-table td.phone {
            font-weight: bold;
            white-space: normal;
            max-width: 120px;
        }

        .phone-number {
            display: block;
            margin: 3px 0;
        }

        .summary-label {
            font-size: 16px;
            color: #1a5276;
            font-weight: 600;
        }

        .totals-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #1a5276;
            page-break-inside: avoid;
            /* Keep totals together */
        }

        .totals-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        @media print {
            .invoice-table {
                box-shadow: none;
            }

            .invoice-table thead tr {
                background: #1a5276 !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .info-box {
                background: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            body {
                color: #000;
            }
        }
    </style>
</head>

<body>
    <div class="main-report">
        <div class="driver-section">
            <div class="info-box">
                اسم السائق:
                <span><?php echo e($data['driver_name'] ?? '—'); ?></span>
            </div>
            <div class="info-box">
                تاريخ التقرير:
                <span><?php echo e($data['date'] ?? 'غير محدد'); ?></span>
            </div>
        </div>


        <div class="report-content">

            <?php $__currentLoopData = array_chunk($data['driverInvoices'], 11); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkIndex => $invoiceChunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الفاتورة</th>
                            <th style="width: 300px;">العنوان</th>
                            <th>الهاتف</th>
                            <th>التوصيل</th>
                            <th>الإجمالي</th>
                            <th>المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $invoiceChunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1 + ($chunkIndex * 11)); ?></td>
                                <td><?php echo e($invoice['invoice_number'] ?? '—'); ?></td>
                                <td style="width: 300px;text-align: right;" class="address"><?php echo e($invoice['address'] ?? '—'); ?>

                                </td>
                                <td style="letter-spacing: 1px;" class="phone">
                                    <?php
                                        $phones = explode(',', $invoice['mobile'] ?? '');
                                        foreach ($phones as $phone) {
                                            echo '<span class="phone-number">' . trim($phone) . '</span>';
                                        }
                                    ?>
                                </td>
                                <td><?php echo e(number_format($invoice['taxi_price'] ?? 0)); ?></td>
                                <td><?php echo e(number_format($invoice['total'] ?? 0)); ?></td>
                                <td><?php echo e(number_format($invoice['grand_total'] ?? 0)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                
                <?php if(!$loop->last): ?>
                    <div style="page-break-after: always;"></div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="totals-section">
                <div class="totals-grid">
                    <div class="info-box">
                        إجمالي الفواتير:
                        <label class="summary-label"><?php echo e(number_format($data['total_invoice_total'] ?? 0)); ?></label>
                    </div>
                    <div class="info-box">
                        إجمالي التوصيل:
                        <label class="summary-label"><?php echo e(number_format($data['total_taxi_price'] ?? 0)); ?></label>
                    </div>
                    <div class="info-box">
                        الإجمالي الكلي:
                        <label
                            class="summary-label"><?php echo e(number_format(($data['total_invoice_total'] ?? 0) + ($data['total_taxi_price'] ?? 0))); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\print\printdrivers.blade.php ENDPATH**/ ?>