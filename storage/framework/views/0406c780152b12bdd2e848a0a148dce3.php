<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>A6 Invoice Print</title>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            html, body {
                margin: 0 !important;
                padding: 0 !important;
            }

            .page-break {
                page-break-after: always;
            }
        }

        body {
            color: #813434;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
            background: white;
        }

        .invoices-wrapper {
            background: #f5f5f5;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .invoice-container {
            width: 105mm;
            height: 148mm;
            margin: 0 auto 20px auto;
            background: white;
            page-break-inside: avoid;
        }

        .invoice-inner {
            padding: 35mm 11mm 5mm 5mm;
            height: calc(100% - 15mm);
            box-sizing: border-box;
        }

        .driver-info {
            margin-bottom: 8mm;
            margin-right: 5mm;
        }

        .info-line {
            margin-bottom: 1.7mm;
        }

        /* Table fixed layout so it never expands A6 size */
        .product-table {
            width: 100%;
            max-width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            font-size: 10px;
            color: #4a2b2b;
            background-color: #fff8f7;
            box-shadow: 0 2px 6px rgba(129, 52, 52, 0.15);
            margin-bottom: 5mm;
            word-wrap: break-word;
        }

        .product-table th,
        .product-table td {
            padding: 4px 6px;
            text-align: right;
            border-bottom: 1px solid #d9b7b7;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Name column is quarter width of code column */
        .product-table th.name-col,
        .product-table td.name-col {
            width: 20mm; /* quarter of code column */
            max-width: 20mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Code column */
        .product-table th.code-col,
        .product-table td.code-col {
            width: 13mm;    
            max-width: 13mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-table th.col-num,
        .product-table td.col-num {
            width: 5mm;
        }

        .product-table th.qty-col,
        .product-table td.qty-col {
            width: 10mm;
        }

        .product-table th.price-col,
        .product-table td.price-col {
            width: 11mm;
        }

        .product-table th.total-col,
        .product-table td.total-col {
            width: 15mm;
        }

        .product-table thead th {
            background-color: #f3dcdc;
            font-weight: bold;
        }

        .product-table tbody tr:nth-child(even) {
            background-color: #fff0ef;
        }

        .totals {
            display: flex;
            flex-direction: column;
            gap: 3mm;
        }

        .total-line {
            white-space: nowrap;
            font-size: 12px;
            color: #4a2b2b;
        }

        .grand-total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoices-wrapper">
        <?php $__currentLoopData = $data['invoices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="invoice-container">
                <div class="invoice-inner">
                    <?php if($invoice['show_header']): ?>
                        <div class="driver-info" style="margin-top: 3mm;">
                            <div class="info-line"><strong>السائق:</strong> <?php echo e($data['driver_name']); ?></div>
                            <div class="info-line"><strong>العنوان:</strong> <?php echo e($invoice['address']); ?></div>
                            <div class="info-line"><strong>الموبايل:</strong> <?php echo e($invoice['mobile']); ?></div>
                        </div>
                    <?php endif; ?>

                    <table class="product-table">
                        <thead>
                            <tr>
                                <th class="col-num">#</th>
                                <th class="name-col">اسم</th>
                                <th class="code-col">الكود</th>
                                <th class="qty-col">الكمية</th>
                                <th class="price-col">السعر</th>
                                <th class="total-col">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoice['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="col-num"><?php echo e($i + 1); ?></td>
                                    <td class="name-col text-right"><?php echo e($product['name']); ?></td>
                                    <td class="code-col"><?php echo e($product['code'] ?? '—'); ?></td>
                                    <td class="qty-col"><?php echo e($product['qty']); ?></td>
                                    <td class="price-col"><?php echo e(number_format($product['price'])); ?></td>
                                    <td class="total-col"><?php echo e(number_format($product['total'])); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <?php if(!empty($invoice['show_footer'])): ?>
                        <div class="totals">
                            <div class="total-line">المجموع: <?php echo e(number_format($invoice['total'])); ?> د.ع</div>
                            <div class="total-line">التوصيل: <?php echo e(number_format($invoice['taxi_price'])); ?> د.ع</div>
                            <div class="total-line grand-total">الإجمالي: <?php echo e(number_format($invoice['grand_total'])); ?> د.ع</div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <?php if(!$loop->last): ?>
                <div class="page-break"></div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</body>

</html>
<?php /**PATH C:\Users\PC\Desktop\New folder (6)\laxe8-12\resources\views\print\invoices.blade.php ENDPATH**/ ?>