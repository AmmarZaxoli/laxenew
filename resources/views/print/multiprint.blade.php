<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Floral Pink Invoice</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>

        @media print {
            @page {
                size: A6 portrait;
                margin: 0;
            }

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                background: white;
                display: flex;
                justify-content: center;
                align-items: flex-start;
            }

            .invoice-container {
                page-break-inside: avoid;
            }

            .page-break {
                page-break-after: always;
            }
        }

        body {
            font-family: 'Cairo', Arial, sans-serif;
            color: #000;
            background: white;
            margin: 0;
            padding: 0;
        }

        .invoices-wrapper {
            background: #f5f5f5;
            box-sizing: border-box;
        }

        .invoice-container {
            width: 101mm;
            height: 144mm;
            background: white;
            position: relative;
            box-sizing: border-box;
            overflow: hidden;
        }

        .floral-decoration {
            position: absolute;
            opacity: 0.15;
            z-index: 0;
        }

        .floral-top-right {
            top: 0;
            right: 0;
            width: 30mm;
            transform: rotate(180deg);
        }

        .floral-bottom-left {
            bottom: 0;
            left: 0;
            width: 30mm;
        }

        .star-decoration {
            position: absolute;
            opacity: 0.1;
            z-index: 0;
        }

        .star-top-left {
            top: 5mm;
            left: 5mm;
            width: 15mm;
        }

        .star-bottom-right {
            bottom: 5mm;
            right: 5mm;
            width: 15mm;
            transform: rotate(15deg);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0mm;
            position: relative;
            z-index: 1;
        }

        .invoice-header::after {
            content: '';
            position: absolute;
            top: 31mm;
            left: 0;
            width: 100%;
            border-bottom: 1px dashed #813434;
        }

        .logo-container {
            flex: none;
            text-align: center;
            margin-bottom: 5px;
            order: 1;
        }

        .logo-container img {
            max-width: 57mm;
            max-height: 32mm;
            height: auto;
            display: block;
            margin-bottom: 30px;
            margin: 0 auto;
        }

        .qr-container {
            order: 1;
            text-align: left;
        }

        .icons-container {
            order: 3;
            text-align: right;
            transform: translateX(10px);
        }

        .social-media {
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: flex-end;
        }

        .social-item {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }

        .social-item i {
            margin-right: 0;
            min-width: 15px;
            color: #813434;
        }

        .social-icon {
            font-size: 14px;
            color: #813434;
            margin-right: 2mm;
        }

        .customer-info {
            padding: 0mm 3mm;
            position: relative;
            z-index: 1;
        }

        .info-line {
            font-size: 13px;
            color: #813434;
            margin-bottom: 1mm;
            display: flex;
            align-items: center;
            gap: 1mm;
        }

        .info-label {
            font-weight: bold;
            color: #813434;
            min-width: auto;
            margin-left: 1mm;
        }

        .info-value {
            flex: 1;
            color: #000000;
            font-weight: bold;
            text-align: right;
        }

        .product-table {
            width: 94%;
            margin-right: 10px;
            margin-left: 20px;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 10px;
            margin-top: 2mm;
            position: relative;
            z-index: 1;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(90, 18, 18, 0.442);
        }

        .product-table th {
            font-size: 10px;
            background-color: #813434;
            color: #813434;
            padding: 1mm 1mm;
            text-align: center;
            border: 1px solid #813434;
            font-weight: bold;
        }

        .product-table td {
            padding: 1.5mm 1mm;
            text-align: center;
            border: 1px solid #813434;
        }

        .product-table tr:nth-child(even) {
            background-color: rgba(129, 52, 52, 0.05);
        }

        .product-table tr:hover {
            background-color: rgba(129, 52, 52, 0.1);
        }

        .invoice-footer {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5mm;
            padding: 3mm;
            margin-top: 2mm;
            position: relative;
            z-index: 1;
        }

        .app-logo {
            height: 8mm;
            filter: hue-rotate(0deg) saturate(1) brightness(0.8);
        }

        .total-section {
            font-size: 11px;
            padding: 1mm 3mm;
            text-align: right;
            position: relative;
            z-index: 1;
        }

        .total-line {
            display: flex;
            gap: 5px;
            margin-bottom: 1mm;
        }

        .grand-total {
            font-weight: bold;
            color: #813434;
            border-top: 1px dashed #813434;
            padding-top: 1mm;
            margin-top: 0.5mm;
        }

        .invoice-footer {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 4mm;
            padding: 2mm 10mm;
            position: absolute;
            bottom: 0;
            width: 100%;
            box-sizing: border-box;
            z-index: 1;
        }

        .app-logo {
            height: 8mm;
            object-fit: contain;
        }

        .store-container {
            border: 1px solid #813434;
            border-radius: 6px;
            padding: 3px 8px;
            display: flex;
            align-items: left;
            gap: 4px;
            font-size: 12px;
            color: #813434;
            font-weight: bold;
        }

        .total-section .note {
            font-size: 12px;
            color: #813434;
            line-height: 1.2;
            word-break: break-word;
        }

        .phone-number {
            font-size: 13px !important;
            font-weight: bold;
            color: #813434;
            letter-spacing: 1.5px;
        }

        .product-table td.product-name {
            max-width: 40mm;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            direction: ltr;
            text-align: left;
        }

        /* FIXED: Proper spacing for subsequent pages */
        .invoice-container.next-page .customer-info,
        .invoice-container.next-page .barcode-container {
            padding-top: 12mm;
        }

        .mt-top-page .customer-info,
        .mt-top-page .barcode-container {
            padding-top: 12mm;
        }
    </style>
</head>

<body>
    <div class="invoices-wrapper">
        @foreach ($data['invoices'] as $invoice)
            <!-- FIXED: Remove duplicate div and fix class logic -->
            <div class="invoice-container @if(!$invoice['show_header']) next-page mt-top-page @endif">

                <!-- Star Decorations -->
                <svg class="star-decoration star-top-left" viewBox="0 0 100 100">
                    <path fill="#813434" d="M50,0 L61,35 L98,35 L68,57 L79,92 L50,70 L21,92 L32,57 L2,35 L39,35 Z" />
                </svg>

                <svg class="star-decoration star-bottom-right" viewBox="0 0 100 100">
                    <path fill="#813434" d="M50,0 L61,35 L98,35 L68,57 L79,92 L50,70 L21,92 L32,57 L2,35 L39,35 Z" />
                </svg>

                @if($invoice['show_header'])
                    <!-- Header Section -->
                    <div class="invoice-header">
                        <!-- QR Code (left) -->
                        <div class="qr-container" style="margin-right: 0px;margin-top: 3px;">
                            <img src="{{ url('images/newqr.png') }}" alt="QR Code" style="width: 26mm; height: 26mm;">
                        </div>

                        <!-- Logo (center) -->
                        <div class="logo-container">
                            @php
                                $logoPath = public_path('images/laxelogo.png');
                                $logoData = null;
                                if (file_exists($logoPath)) {
                                    $logoData = base64_encode(file_get_contents($logoPath));
                                }
                            @endphp

                            @if($logoData)
                                <img src="data:image/png;base64,{{ $logoData }}" alt="Logo">
                            @else
                                <p style="color: red; font-size: 12px;">⚠ Logo not found</p>
                            @endif
                        </div>

                        <!-- Icons / Social Media (right) -->
                        <div class="icons-container">
                            <div class="social-media">
                                <div class="social-item">
                                    <span class="phone-number" style=" font-size: 12px;color: #813434;">07502888383:</span>
                                    <svg style="font-size: 13px;color: #813434;margin-right:3px;"
                                        xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                        class="bi bi-telephone-inbound-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zM15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0" />
                                    </svg>
                                </div>
                                <div class="social-item">
                                    <span class="phone-number" style=" font-size: 12px;color: #813434;">07517597794:</span>
                                    <svg style="font-size:13px; color:#813434;margin-right:3px;"
                                        xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                        class="bi bi-telephone-inbound-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zM15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0" />
                                    </svg>
                                </div>
                                <div class="social-item">
                                    <span style=" font-size: 12px;color: #813434;font-weight: bold;">Laxe_Online :</span>
                                    <svg style="font-size:13px; color:#813434;margin-right:3px;"
                                        xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                        class="bi bi-snapchat" viewBox="0 0 16 16">
                                        <path
                                            d="M15.943 11.526c-.111-.303-.323-.465-.564-.599a1 1 0 0 0-.123-.064l-.219-.111c-.752-.399-1.339-.902-1.746-1.498a3.4 3.4 0 0 1-.3-.531c-.034-.1-.032-.156-.008-.207a.3.3 0 0 1 .097-.1c.129-.086.262-.173.352-.231.162-.104.289-.187.371-.245.309-.216.525-.446.66-.702a1.4 1.4 0 0 0 .069-1.16c-.205-.538-.713-.872-1.329-.872a1.8 1.8 0 0 0-.487.065c.006-.368-.002-.757-.035-1.139-.116-1.344-.587-2.048-1.077-2.61a4.3 4.3 0 0 0-1.095-.881C9.764.216 8.92 0 7.999 0s-1.76.216-2.505.641c-.412.232-.782.53-1.097.883-.49.562-.96 1.267-1.077 2.61-.033.382-.04.772-.036 1.138a1.8 1.8 0 0 0-.487-.065c-.615 0-1.124.335-1.328.873a1.4 1.4 0 0 0 .067 1.161c.136.256.352.486.66.701.082.058.21.14.371.246l.339.221a.4.4 0 0 1 .109.11c.026.053.027.11-.012.217a3.4 3.4 0 0 1-.295.52c-.398.583-.968 1.077-1.696 1.472-.385.204-.786.34-.955.8-.128.348-.044.743.28 1.075q.18.189.409.31a4.4 4.4 0 0 0 1 .4.7.7 0 0 1 .202.09c.118.104.102.26.259.488q.12.178.296.3c.33.229.701.243 1.095.258.355.014.758.03 1.217.18.19.064.389.186.618.328.55.338 1.305.802 2.566.802 1.262 0 2.02-.466 2.576-.806.227-.14.424-.26.609-.321.46-.152.863-.168 1.218-.181.393-.015.764-.03 1.095-.258a1.14 1.14 0 0 0 .336-.368c.114-.192.11-.327.217-.42a.6.6 0 0 1 .19-.087 4.5 4.5 0 0 0 1.014-.404c.16-.087.306-.2.429-.336l.004-.005c.304-.325.38-.709.256-1.047m-1.121.602c-.684.378-1.139.337-1.493.565-.3.193-.122.61-.34.76-.269.186-1.061-.012-2.085.326-.845.279-1.384 1.082-2.903 1.082s-2.045-.801-2.904-1.084c-1.022-.338-1.816-.14-2.084-.325-.218-.15-.041-.568-.341-.761-.354-.228-.809-.187-1.492-.563-.436-.24-.189-.39-.044-.46 2.478-1.199 2.873-3.05 2.89-3.188.022-.166.045-.297-.138-.466-.177-.164-.962-.65-1.18-.802-.36-.252-.52-.503-.402-.812.082-.214.281-.295.49-.295a1 1 0 0 1 .197.022c.396.086.78.285 1.002.338q.04.01.082.011c.118 0 .16-.06.152-.195-.026-.433-.087-1.277-.019-2.066.094-1.084.444-1.622.859-2.097.2-.229 1.137-1.22 2.93-1.22 1.792 0 2.732.987 2.931 1.215.416.475.766 1.013.859 2.098.068.788.009 1.632-.019 2.065-.01.142.034.195.152.195a.4.4 0 0 0 .082-.01c.222-.054.607-.253 1.002-.338a1 1 0 0 1 .197-.023c.21 0 .409.082.49.295.117.309-.04.56-.401.812-.218.152-1.003.638-1.18.802-.184.169-.16.3-.139.466.018.14.413 1.991 2.89 3.189.147.073.394.222-.041.464" />
                                    </svg>
                                </div>
                                <div class="social-item">
                                    <span style="font-size: 12px;color: #813434;font-weight: bold;">Laxe__Online :</span>
                                    <svg style="font-size:13px; color:#813434;margin-right:3px;"
                                        xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                        class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path
                                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                                    </svg>
                                </div>
                                <div class="social-item" style="font-size: 12px;color: #813434;font-weight: bold;
                                                                ">
                                    <span style="font-size: 12px;color: #813434;font-weight: bold;">www.laxeonline.com</span>
                                    <svg style="font-size:13px; color:#813434;margin-right:3px;"
                                        xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                        class="bi bi-browser-chrome" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M16 8a8 8 0 0 1-7.022 7.94l1.902-7.098a3 3 0 0 0 .05-1.492A3 3 0 0 0 10.237 6h5.511A8 8 0 0 1 16 8M0 8a8 8 0 0 0 7.927 8l1.426-5.321a3 3 0 0 1-.723.255 3 3 0 0 1-1.743-.147 3 3 0 0 1-1.043-.7L.633 4.876A8 8 0 0 0 0 8m5.004-.167L1.108 3.936A8.003 8.003 0 0 1 15.418 5H8.066a3 3 0 0 0-1.252.243 2.99 2.99 0 0 0-1.81 2.59M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Customer Info & Barcode -->
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <!-- Customer Info (right) -->
                    <div class="customer-info" style="text-align: right;">
                        <div class="info-line">
                            <div class="info-label">السائق:</div>
                            <!-- FIXED: Use invoice driver_name instead of data driver_name -->
                            <div class="info-value">{{ $invoice['driver_name'] ?: ($data['driver_name'] ?? '—') }}</div>
                        </div>
                        <div class="info-line">
                            <div class="info-label">العنوان:</div>
                            <div class="info-value">{{ $invoice['address'] ?? '—' }}</div>
                        </div>
                        <div class="info-line">
                            <div class="info-label">الهاتف:</div>
                            <div style="letter-spacing: 1.5px;" class="info-value">{{ $invoice['mobile'] }}</div>
                        </div>
                    </div>

                    <!-- Barcode (left) -->
                    <div class="barcode-container" style="text-align: center; margin-left: 14px;margin-top: 1px">
                        <span style="font-size: 13px;;color: #813434;" class="info-value">{{ $invoice['date_sell'] }}</span>

                        <img src="data:image/png;base64,{{ $invoice['barcodePNG'] }}" alt="Invoice Barcode"
                            style="height: 23px; display: block; margin: 0 auto;">

                        <div style="font-size: 14px; font-weight: bold; margin-top: 1px;color: #813434;">
                            {{ $invoice['invoice_number'] ?? '—' }}
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <table class="product-table">
                    <thead>
                        <tr>
                            <th style="width: 6mm">#</th>
                            <th>اسم </th>
                            <th style="width: 13mm">الكود</th>
                            <th style="width: 8mm">الكمية</th>
                            <th style="width: 11mm">السعر</th>
                            <th style="width: 13mm">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice['products'] as $i => $product)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="product-name" style="text-align: center;">{{ $product['name'] }}</td>
                                <td>{{ $product['code'] }}</td>
                                <td>{{ $product['qty'] }}</td>
                                <td>{{ number_format($product['price']) }} </td>
                                <td>{{ number_format($product['total']) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($invoice['show_footer'])
                    <div class="total-section">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 5mm;">
                            {{-- Totals on the left --}}
                            <div style="text-align: left;">
                                <div class="total-line">
                                    <span>المجموع :</span>
                                    <span>{{ number_format($invoice['total']) }}</span>
                                </div>
                                <div class="total-line">
                                    <span>التوصيل :</span>
                                    <span>{{ number_format($invoice['taxi_price']) }}</span>
                                </div>
                                <div class="total-line">
                                    <span>الخصم :</span>
                                    <span>{{ number_format($invoice['discount']) }}</span>
                                </div>
                                <div class="total-line grand-total">
                                    <span>الإجمالي النهائي :</span>
                                    <span>{{ number_format($invoice['total_price_afterDiscount_invoice']) }}</span>
                                </div>
                                @if(!empty($invoice['waypayment']) && $invoice['waypayment'] == 'FIB')
                                    <div class="total-line grand-total">
                                        <div>طريقة الدفع:</div>
                                        <div >{{ $invoice['waypayment'] }}</div>
                                    </div>
                                @endif
                            </div>

                            {{-- Note on the right --}}
                            @if(!empty($invoice['note']))
                                <span class="note"
                                    style="font-size: 12px; color: #000000; max-width: 50%; display: block; text-align: right;">
                                    {{ $invoice['note'] }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Footer with Store Buttons -->
                <div class="invoice-footer">
                    <div class="store-container">
                        <span>App Store </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
                            class="bi bi-apple" viewBox="0 0 16 16">
                            <path
                                d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516s1.52.087 2.475-1.258.762-2.391.728-2.43m3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422s1.675-2.789 1.698-2.854-.597-.79-1.254-1.157a3.7 3.7 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56s.625 1.924 1.273 2.796c.576.984 1.34 1.667 1.659 1.899s1.219.386 1.843.067c.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758q.52-1.185.473-1.282" />
                        </svg>
                    </div>
                    <div class="store-container">
                        <span>Google Play </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
                            class="bi bi-google-play" viewBox="0 0 16 16">
                            <path
                                d="M14.222 9.374c1.037-.61 1.037-2.137 0-2.748L11.528 5.04 8.32 8l3.207 2.96zm-3.595 2.116L7.583 8.68 1.03 14.73c.201 1.029 1.36 1.61 2.303 1.055zM1 13.396V2.603L6.846 8zM1.03 1.27l6.553 6.05 3.044-2.81L3.333.215C2.39-.341 1.231.24 1.03 1.27" />
                        </svg>
                    </div>
                </div>

            </div>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>
</body>

</html>