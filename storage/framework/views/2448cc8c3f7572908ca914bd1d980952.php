<div>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
            margin-bottom: 1.5rem;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            background-color: white;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card .card-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;

        }

        .stat-card .card-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
            line-height: 1.2;
        }

        .stat-card .card-subtext {
            font-size: 0.75rem;
            color: var(--gray);
            display: flex;
            align-items: center;
        }

        .trend-up {
            color: var(--success);
        }

        .trend-down {
            color: var(--secondary);
        }

        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }

        .section-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
        }

        .quick-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
            text-align: center;
            color: var(--dark);
            text-decoration: none;
            min-height: 90px;
        }

        .quick-action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            color: var(--primary);
        }

        .quick-action-btn i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .quick-action-btn span {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .stat-card .card-value {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 992px) {
            .chart-container {
                height: 300px;
            }

            .stat-card .card-value {
                font-size: 1.4rem;
            }

            .card-icon {
                width: 42px;
                height: 42px;
                font-size: 1.3rem;
                margin-bottom: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-header {
                margin-bottom: 1rem;
                border-radius: 0 0 15px 15px;
            }

            .dashboard-header h1 {
                font-size: 1.25rem !important;
            }

            .dashboard-header p {
                font-size: 0.9rem;
            }

            .quick-actions {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.75rem;
            }

            .quick-action-btn {
                padding: 0.75rem 0.5rem;
                min-height: 85px;
            }

            .quick-action-btn i {
                font-size: 1.3rem;
            }

            .quick-action-btn span {
                font-size: 0.7rem;
            }

            .stat-card .card-value {
                font-size: 1.3rem;
            }

            .stat-card .card-icon {
                width: 45px;
                height: 45px;
                font-size: 1.25rem;
            }

            .stat-card .card-title {
                font-size: 0.8rem;
            }

            .card-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
            }

            .chart-container {
                height: 280px;
            }

            .section-title {
                font-size: 1.1rem;
                margin-bottom: 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .dashboard-header {
                padding: 1rem 0 !important;
            }

            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .quick-action-btn {
                padding: 0.75rem 0.25rem;
                min-height: 80px;
            }

            .quick-action-btn i {
                font-size: 1.25rem;
                margin-bottom: 0.25rem;
            }

            .quick-action-btn span {
                font-size: 0.65rem;
            }

            .stat-card .card-value {
                font-size: 1.2rem;
            }

            .stat-card .card-title {
                font-size: 0.75rem;
                margin-bottom: 0.25rem;
            }

            .card-icon {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }

            .chart-container {
                height: 250px;
            }

            .section-title {
                font-size: 1rem;
                margin-bottom: 1rem;
            }

            .container-fluid {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }

            .card-body {
                padding: 1.25rem !important;
            }
        }

        @media (max-width: 480px) {
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-card .card-value {
                font-size: 1.08rem;
            }

            .chart-container {
                height: 220px;
            }

            .quick-action-btn {
                min-height: 75px;
            }

            .stat-card .card-icon {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 360px) {
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.4rem;
            }

            .quick-action-btn {
                min-height: 70px;
                padding: 0.5rem 0.25rem;
            }

            .quick-action-btn i {
                font-size: 1.1rem;
            }

            .stat-card .card-value {
                font-size: 1rem;
            }

            .card-icon {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }
        }
    </style>

    <!-- Dashboard Header -->
    <header class="dashboard-header py-3 py-md-4">
        <div class="container-fluid px-3 px-md-4">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="h4 mb-1 mb-md-2">لوحة القيادة</h1>
                    <p class="mb-0 text-white">مرحباً بك مجدداً, <span
                            style="font-weight: 600;color:#ffffff"><?php echo e(auth('account')->user()->name); ?></span> إليكم ما
                        يحدث اليوم.</p>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid px-3 px-md-4 pb-4 pb-md-5">
        <!-- Quick Actions -->
        <div class="row mb-3 mb-md-4">
            <div class="col-12">
                <div class="quick-actions">
                    <a href="<?php echo e(route('accountdrivers.create')); ?>" class="quick-action-btn">
                        <i class="bi bi-qr-code-scan"></i>
                        <span>مسح ضوئي للفواتير</span>
                    </a>
                    <a href="<?php echo e(route('selling.create')); ?>" class="quick-action-btn">
                        <i class="bi bi-cart-plus"></i>
                        <span>بيع المنتجات</span>
                    </a>
                    <a href="<?php echo e(route('products.create')); ?>" class="quick-action-btn">
                        <i class="bi bi-box-seam"></i>
                        <span>المخزن</span>
                    </a>
                    <a href="<?php echo e(route('returnsell.create')); ?>" class="quick-action-btn">
                        <i class="bi bi-receipt"></i>
                        <span>إرجاع الفواتير</span>
                    </a>
                    <a href="<?php echo e(route('offers.edit')); ?>" class="quick-action-btn">
                        <i class="bi bi-gift"></i>
                        <span>تعديل العروض</span>
                    </a>
                    <a href="<?php echo e(route('accounting.create')); ?>" class="quick-action-btn">
                        <i class="bi bi-calculator"></i>
                        <span>الحسابات</span>
                    </a>
                    <a href="<?php echo e(route('expenses.create')); ?>" class="quick-action-btn">
                        <i class="bi bi-cash-coin"></i>
                        <span>مصروفات</span>
                    </a>
                    <a href="<?php echo e(route('accounts.create')); ?>" class="quick-action-btn">
                        <i class="bi bi-person-plus"></i>
                        <span>المستخدمين</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Stats - FIXED RESPONSIVE SECTION -->
        <div class="row g-2 g-md-3 mb-3 mb-md-4">
            <!-- Today's Sales -->
            <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body p-2 p-md-3 text-center text-sm-start">
                        <div class="card-icon bg-primary bg-opacity-10 text-primary mx-auto mx-sm-0">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <h6 class="card-title mb-1">مبيعات اليوم</h6>
                        <h3 class="card-value"><?php echo e(number_format($totalpriceall)); ?> د.ع</h3>
                    </div>
                </div>
            </div>

            <!-- Weekly Sales -->
            <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body p-2 p-md-3 text-center text-sm-start">
                        <div class="card-icon bg-success bg-opacity-10 text-success mx-auto mx-sm-0">
                            <i class="bi bi-calendar-week"></i>
                        </div>
                        <h6 class="card-title mb-1">المبيعات هذا الأسبوع</h6>
                        <h3 class="card-value"><?php echo e(number_format($weekSales)); ?> د.ع</h3>
                    </div>
                </div>
            </div>

            <!-- Customer Orders -->
            <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body p-2 p-md-3 text-center text-sm-start">
                        <div class="card-icon bg-warning bg-opacity-10 text-warning mx-auto mx-sm-0">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h6 class="card-title mb-1">طلبات العملاء</h6>
                        <h3 class="card-value"><?php echo e(number_format($countorder)); ?></h3>
                    </div>
                </div>
            </div>

            <!-- Today's Orders -->
            <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body p-2 p-md-3 text-center text-sm-start">
                        <div class="card-icon bg-info bg-opacity-10 text-info mx-auto mx-sm-0">
                            <i class="bi bi-bag-check"></i>
                        </div>
                        <h6 class="card-title mb-1">جميع الطلبات اليوم</h6>
                        <h3 class="card-value"><?php echo e(number_format($countordersale)); ?></h3>
                    </div>
                </div>
            </div>

            <!-- Total Debts -->
            <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body p-2 p-md-3 text-center text-sm-start">
                        <div class="card-icon bg-secondary bg-opacity-10 text-secondary mx-auto mx-sm-0">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h6 class="card-title mb-1">إجمالي الديون</h6>
                        <h3 class="card-value"><?php echo e(number_format($totalprice)); ?> د.ع</h3>
                    </div>
                </div>
            </div>

            <!-- Deleted Invoices -->
            <div class="col-12 col-sm-6 col-md-4 col-lg">
                <div class="card stat-card h-100">
                    <div class="card-body p-2 p-md-3 text-center text-sm-start">
                        <div class="card-icon bg-danger bg-opacity-10 text-danger mx-auto mx-sm-0">
                            <i class="bi bi-trash"></i>
                        </div>
                        <h6 class="card-title mb-1">عدد حذف الفواتير</h6>
                        <h3 class="card-value"><?php echo e(number_format($totaldelete)); ?></h3>
                    </div>
                </div>
            </div>
        </div>

 


        <!-- Charts Row -->
        <div class="row g-2 g-md-3 mb-3 mb-md-4">
            <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                <div class="card h-100">
                    <div class="card-body p-2 p-md-3">
                        <h5 class="section-title">المبيعات - آخر 7 أيام</h5>
                        <div class="chart-container">
                            <canvas id="sales7Chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card h-100">
                    <div class="card-body p-2 p-md-3">
                        <h5 class="section-title">طرق الدفع</h5>
                        <div class="chart-container">
                            <canvas id="paymentMethodsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS for Charts -->
    <script>
        // Sales Chart — Last 7 Days
        const salesCtx = document.getElementById('sales7Chart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($salesLabels, 15, 512) ?>,
                datasets: [{
                    label: 'Sales',
                    data: <?php echo json_encode($salesData, 15, 512) ?>,
                    fill: true,
                    tension: 0.3,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    pointBackgroundColor: '#6366f1',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: function(context) {
                                    const width = context.chart.width;
                                    return width < 500 ? 10 : width < 768 ? 11 : 12;
                                }
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: function(context) {
                                    const width = context.chart.width;
                                    return width < 500 ? 10 : width < 768 ? 11 : 12;
                                }
                            }
                        }
                    }
                }
            }
        });

        // Payment Methods Chart
        const paymentCtx = document.getElementById('paymentMethodsChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($paymentLabels, 15, 512) ?>,
                datasets: [{
                    data: <?php echo json_encode($paymentData, 15, 512) ?>,
                    backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#0ea5e9'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: function(context) {
                                const width = context.chart.width;
                                return width < 500 ? 10 : 20;
                            },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: function(context) {
                                    const width = context.chart.width;
                                    return width < 500 ? 10 : width < 768 ? 11 : 12;
                                }
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: {
                            size: function(context) {
                                const width = context.chart.width;
                                return width < 500 ? 11 : width < 768 ? 12 : 14;
                            },
                            weight: '600'
                        },
                        bodyFont: {
                            size: function(context) {
                                const width = context.chart.width;
                                return width < 500 ? 10 : width < 768 ? 11 : 12;
                            }
                        },
                        padding: function(context) {
                            const width = context.chart.width;
                            return width < 500 ? 8 : 12;
                        },
                        cornerRadius: 8
                    }
                }
            }
        });
    </script>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/dashboards/show.blade.php ENDPATH**/ ?>