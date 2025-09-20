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

        body,
        html {
            height: 100%;
            background-color: white;
            color: #333;
        }

        @page {
            size: A4;
            margin: 15mm;
        }

        .main-report {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            width: 100%;
            margin: 0;
            background: white;
        }

        .content {
            flex: 1;
        }

        /* ===== Header ===== */
        .report-header {
            text-align: center;
            border-bottom: 2px solid #1a5276;
            margin-bottom: 0.5rem;
            padding-bottom: 0.3rem;
        }

        .report-header h1 {
            font-size: 18px;
            font-weight: 700;
            color: #1a5276;
        }

        .driver-info {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #1a5276;
            margin-top: 3px;
        }

        .driver-info span {
            font-weight: 600;
        }

        /* ===== Table Styling ===== */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0.5rem 0;
            font-size: 13px;
        }

        .invoice-table thead {
            display: table-header-group;
        }

        .invoice-table thead tr {
            background: #1a5276;
            color: white;
            text-align: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .invoice-table th {
            padding: 6px 4px;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid #ddd;
        }

        .invoice-table td {
            padding: 6px 4px;
            border: 1px solid #e0e0e0;
            max-width: 200px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            color: #34495e;
            font-size: 12px;
            line-height: 1.2;
        }

        .invoice-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .invoice-table tr:hover {
            background-color: #eaf2f8;
        }

        .invoice-table td.address {
            text-align: right;
            font-weight: bold;
            white-space: normal;
        }

        .invoice-table td.phone {
            font-weight: bold;
            white-space: normal;
        }

        .phone-number {
            display: block;
        }

        /* ===== Totals Section ===== */
        .totals-section {
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-left: 4px solid #1a5276;
            border-radius: 6px;
            page-break-inside: avoid;
        }

        .totals-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .summary-label {
            font-size: 14px;
            font-weight: 600;
            color: #1a5276;
        }

        /* ===== Footer ===== */
        .report-footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            border-top: 1px solid #ccc;
            padding: 6px 0;
            margin-top: auto; /* push to bottom */
            page-break-inside: avoid;
        }

        .report-footer .page-number:after {
            content: "الصفحة " counter(page) " من " counter(pages);
        }

        @media print {
            body {
                color: #000;
            }

            .invoice-table {
                box-shadow: none;
            }

            .totals-section {
                background: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="main-report">
        <div class="content">
            <?php $__currentLoopData = array_chunk($data['driverInvoices'], 25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkIndex => $invoiceChunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- رأس التقرير -->
                <div class="report-header">
                    <h1>تقرير الفواتير</h1>
                    <div class="driver-info">
                        <div>اسم السائق: <span><?php echo e($data['driver_name'] ?? '—'); ?></span></div>
                        <div>تاريخ التقرير: <span><?php echo e($data['date'] ?? 'غير محدد'); ?></span></div>
                    </div>
                </div>

                <!-- جدول الفواتير -->
                <table class="invoice-table" style="<?php if($loop->last): ?> page-break-after:auto; <?php else: ?> page-break-after:always; <?php endif; ?>">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 70px;">الفاتورة</th>
                            <th style="width: 220px;">العنوان</th>
                            <th>الهاتف</th>
                            <th>التوصيل</th>
                            <th>الإجمالي</th>
                            <th>المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $invoiceChunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1 + ($chunkIndex * 25)); ?></td>
                                <td style="text-align: center;font-weight: 600;font-size: 16px;">
                                    <?php echo e($invoice['invoice_number'] ?? '—'); ?>

                                </td>
                                <td class="address"><?php echo e($invoice['address'] ?? '—'); ?></td>
                                <td class="phone" style="text-align: center;font-weight: 600;font-size: 16px;">
                                    <?php
                                        $phones = explode(',', $invoice['mobile'] ?? '');
                                        foreach ($phones as $phone) {
                                            echo '<span class="phone-number">' . trim($phone) . '</span>';
                                        }
                                    ?>
                                </td>
                                <td style="text-align: center"><?php echo e(number_format($invoice['taxi_price'] ?? 0)); ?></td>
                                <td style="text-align: center"><?php echo e(number_format($invoice['total'] ?? 0)); ?></td>
                                <td style="font-weight: 600;font-size: 16px;text-align: center">
                                    <?php echo e(number_format($invoice['grand_total'] ?? 0)); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="report-footer">
            <div class="totals-section">
                <div class="totals-grid">
                    <div>
                        إجمالي الفواتير:
                        <label class="summary-label"><?php echo e(number_format($data['total_invoice_total'] ?? 0)); ?></label>
                    </div>
                    <div>
                        إجمالي التوصيل:
                        <label class="summary-label"><?php echo e(number_format($data['total_taxi_price'] ?? 0)); ?></label>
                    </div>
                    <div>
                        الإجمالي الكلي:
                        <label class="summary-label">
                            <?php echo e(number_format(($data['total_invoice_total'] ?? 0) + ($data['total_taxi_price'] ?? 0))); ?>

                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\Users\user\Desktop\laxe8-10 (7)\resources\views\print\printdrivers.blade.php ENDPATH**/ ?>