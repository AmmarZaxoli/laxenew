<div>
    <!DOCTYPE html>
<html lang="en">
<head>
   

    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --secondary: #f43f5e;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --gray-light: #e2e8f0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
            -webkit-font-smoothing: antialiased;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
            margin-bottom: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            background-color: white;
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
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
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
        
        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Dashboard Header -->
    <header class="dashboard-header py-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h4 mb-0">Dashboard</h1>
                    <p class="mb-0 opacity-75">Welcome back, Admin! Here's what's happening today.</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <span class="badge bg-white text-primary me-2">Today: <span id="current-date">Loading...</span></span>
                    <button class="btn btn-sm btn-outline-light">
                        <i class="bi bi-bell"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-light ms-2">
                        <i class="bi bi-gear"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid pb-5">
        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="quick-actions">
                    <a href="#" class="quick-action-btn">
                        <i class="bi bi-cart-plus"></i>
                        <span>New Sale</span>
                    </a>
                    <a href="#" class="quick-action-btn">
                        <i class="bi bi-people"></i>
                        <span>Customers</span>
                    </a>
                    <a href="#" class="quick-action-btn">
                        <i class="bi bi-box-seam"></i>
                        <span>Inventory</span>
                    </a>
                    <a href="#" class="quick-action-btn">
                        <i class="bi bi-receipt"></i>
                        <span>Invoices</span>
                    </a>
                    <a href="#" class="quick-action-btn">
                        <i class="bi bi-truck"></i>
                        <span>Delivery</span>
                    </a>
                    <a href="#" class="quick-action-btn">
                        <i class="bi bi-graph-up"></i>
                        <span>Reports</span>
                    </a>
                    <a href="#" class="quick-action-btn">
                        <i class="bi bi-cash-coin"></i>
                        <span>Expenses</span>
                    </a>
                    <a href="#" class="quick-action-btn">
                        <i class="bi bi-person-plus"></i>
                        <span>New Staff</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Stats -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="card-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <h6 class="card-title">Today's Sales</h6>
                        <h3 class="card-value">$1,245.00</h3>
                        <p class="card-subtext">
                            <span class="trend-up me-1"><i class="bi bi-arrow-up"></i> 12%</span>
                            vs yesterday
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="card-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-calendar-week"></i>
                        </div>
                        <h6 class="card-title">This Week</h6>
                        <h3 class="card-value">$8,790.50</h3>
                        <p class="card-subtext">
                            <span class="trend-up me-1"><i class="bi bi-arrow-up"></i> 8%</span>
                            vs last week
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="card-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h6 class="card-title">Deliveries</h6>
                        <h3 class="card-value">45</h3>
                        <p class="card-subtext">
                            <span class="trend-down me-1"><i class="bi bi-arrow-down"></i> 3%</span>
                            vs yesterday
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="card-icon bg-secondary bg-opacity-10 text-secondary">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h6 class="card-title">Total Debt</h6>
                        <h3 class="card-value">$3,210.00</h3>
                        <p class="card-subtext">
                            <span class="trend-up me-1"><i class="bi bi-arrow-up"></i> 5%</span>
                            overdue
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="section-title">Sales — Last 7 Days</h5>
                        <div class="chart-container">
                            <canvas id="sales7Chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="section-title">Payment Methods</h5>
                        <div class="chart-container">
                            <canvas id="paymentMethodsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Stats -->
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="card-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h6 class="card-title">New Customers</h6>
                        <h3 class="card-value">27</h3>
                        <p class="card-subtext">
                            <span class="trend-up me-1"><i class="bi bi-arrow-up"></i> 15%</span>
                            last 7 days
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="card-icon bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <h6 class="card-title">Low Stock</h6>
                        <h3 class="card-value">12</h3>
                        <p class="card-subtext">
                            <span class="trend-down me-1"><i class="bi bi-arrow-down"></i> 8%</span>
                            reorder soon
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="card-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <h6 class="card-title">Orders Today</h6>
                        <h3 class="card-value">38</h3>
                        <p class="card-subtext">
                            <span class="trend-up me-1"><i class="bi bi-arrow-up"></i> 22%</span>
                            active
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="card-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-arrow-return-left"></i>
                        </div>
                        <h6 class="card-title">Returned Items</h6>
                        <h3 class="card-value">5</h3>
                        <p class="card-subtext">
                            <span class="trend-down me-1"><i class="bi bi-arrow-down"></i> 2%</span>
                            quality control
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set current date
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });

        // Sales Chart
        const salesCtx = document.getElementById('sales7Chart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1500, 1800, 900, 2000, 2400, 3000],
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
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { size: 14, weight: '600' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: { color: 'rgba(226, 232, 240, 0.5)' },
                        ticks: { 
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: { 
                        grid: { display: false }
                    }
                }
            }
        });

        // Payment Methods Chart
        const paymentCtx = document.getElementById('paymentMethodsChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: ['Credit Card', 'Cash', 'Mobile Pay', 'Bank Transfer'],
                datasets: [{
                    data: [45, 30, 15, 10],
                    backgroundColor: [
                        '#6366f1',
                        '#10b981',
                        '#f59e0b',
                        '#0ea5e9'
                    ],
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
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
</div><?php /**PATH C:\Users\Malta Computer\Desktop\laxe8-17login\resources\views/livewire/dashboards/show.blade.php ENDPATH**/ ?>