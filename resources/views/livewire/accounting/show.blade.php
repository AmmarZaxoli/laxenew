<div>
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #6c757d;
            --success: #4cc9a4;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --purple: #7209b7;
            --card-shadow: 0 8px 26px -4px rgba(20, 20, 20, 0.15);
            --card-radius: 16px;
            --transition: all 0.3s ease;
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 2.5rem;
            padding-top: 1rem;
        }

        .page-header h1 {
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-size: 2.2rem;
        }

        .page-header p {
            color: var(--secondary);
            font-size: 1.1rem;
        }

        /* Search Card */
        .search-card {
            background: #fff;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 2.5rem;
            overflow: hidden;
            transition: var(--transition);
        }

        .search-card:hover {
            box-shadow: 0 12px 30px -6px rgba(20, 20, 20, 0.2);
        }

        .search-card .card-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 1.2rem 1.5rem;
            border-radius: var(--card-radius) var(--card-radius) 0 0;
        }

        .search-card .card-body {
            padding: 1.8rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #444;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            transition: var(--transition);
            font-size: 18px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        /* Buttons */
        .btn-gradient {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            margin-bottom: 3px;
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.8rem;
            border-radius: 10px;
            transition: var(--transition);
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, var(--primary-dark), #2a48b5);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 97, 238, 0.25);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 1.8rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px -6px rgba(20, 20, 20, 0.2);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 4px;
        }

        .sales::before {
            background: linear-gradient(90deg, var(--info), #2a6dd4);
        }

        .discount::before {
            background: linear-gradient(90deg, var(--warning), #e07a00);
        }

        .profit::before {
            background: linear-gradient(90deg, var(--success), #3da389);
        }

        .expenses::before {
            background: linear-gradient(90deg, var(--danger), #d11472);
        }

        .net-profit::before {
            background: linear-gradient(90deg, var(--purple), #5a0892);
        }

        .cart::before {
            background: linear-gradient(90deg, #ff6b6b, #f06595);
        }

        /* New cart color */

        .stat-icon {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            display: inline-block;
            padding: 0.8rem;
            border-radius: 12px;
        }

        .sales .stat-icon {
            color: var(--info);
            background: rgba(72, 149, 239, 0.15);
        }

        .discount .stat-icon {
            color: var(--warning);
            background: rgba(248, 150, 30, 0.15);
        }

        .profit .stat-icon {
            color: var(--success);
            background: rgba(76, 201, 164, 0.15);
        }

        .expenses .stat-icon {
            color: var(--danger);
            background: rgba(247, 37, 133, 0.15);
        }

        .net-profit .stat-icon {
            color: var(--purple);
            background: rgba(114, 9, 183, 0.15);
        }

        .cart .stat-icon {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.15);
        }

        /* New cart icon color */

        /* Title & Number Colors */
        .sales h6,
        .sales h3 {
            color: var(--info);
        }

        .discount h6,
        .discount h3 {
            color: var(--warning);
        }

        .profit h6,
        .profit h3 {
            color: var(--success);
        }

        .expenses h6,
        .expenses h3 {
            color: var(--danger);
        }

        .net-profit h6,
        .net-profit h3 {
            color: var(--purple);
        }

        .cart h6,
        .cart h3 {
            color: #ff6b6b;
        }

        /* Cart title color */

        .stat-card h6 {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .stat-card h3 {
            font-weight: 800;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .search-card .card-body {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="card body formtype">
        <div class="container-fluid py-4">
            <!-- Page Header -->
            <div class="page-header">
                <h1>
                    <i class="bi bi-calculator-fill me-2"></i> لوحة المحاسبة
                </h1>
                <p>إدارة حسابات المبيعات والأرباح والمصروفات</p>
            </div>

            <!-- Search Card -->
            <div class="search-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-range me-2"></i> بحث حسب التاريخ
                    </h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label for="startDate" class="form-label">من تاريخ</label>
                                <input type="date" id="startdate" wire:model="startdate"
                                    class="form-control shadow-sm">
                            </div>
                            <div class="col-md-5">
                                <label for="endDate" class="form-label">إلى تاريخ</label>
                                <input type="date" wire:model="enddate" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button wire:click.prevent="calculateTotal" class="btn-gradient w-100">
                                    <i class="bi bi-search me-2"></i> بحث
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Total Sales (Cart) -->
            <div class="stat-card cart">
                <div class="stat-icon">
                    <i class="bi bi-cart-check"></i>
                </div>
                <h6>إجمالي جميع المبيعات</h6>
                <h3>{{ number_format($totalpriceall) }}</h3>
            </div>
            <!-- Statistics Cards -->
            <div class="stats-grid" style="margin-top: 15px">

                <!-- Total Sales (Cart) -->
                <div class="stat-card cart">
                    <div class="stat-icon">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <h6>إجمالي المبيعات استلام</h6>
                    <h3>{{ number_format($total) }}</h3>
                </div>


                <!-- Total Discount -->
                <div class="stat-card discount">
                    <div class="stat-icon">
                        <i class="bi bi-percent"></i>
                    </div>
                    <h6>إجمالي الخصومات</h6>
                    <h3>{{ number_format($totaldiscount) }}</h3>
                </div>

                <!-- Sales After Discount -->
                <div class="stat-card sales">
                    <div class="stat-icon">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>
                    <h6>المبيعات بعد الخصم</h6>
                    <h3>{{ number_format($totalafterdiscount) }}</h3>
                </div>

                <!-- Total Profit -->
                <div class="stat-card profit">
                    <div class="stat-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h6>إجمالي الأرباح</h6>
                    <h3>{{ number_format($totalProfit) }}</h3>
                </div>

                <!-- Total Expenses -->
                <div class="stat-card expenses">
                    <div class="stat-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <h6>إجمالي المصروفات</h6>
                    <h3>{{ number_format($expense) }}</h3>
                </div>

                <!-- Profit After Discount -->
                <div class="stat-card profit">
                    <div class="stat-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h6>الأرباح بعد الخصم</h6>
                    <h3>{{ number_format($totalProfitafterdiscount) }}</h3>
                </div>

                <!-- Net Profit -->
                <div class="stat-card net-profit">
                    <div class="stat-icon">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h6>صافي الربح</h6>
                    <h3>{{ number_format($totalProfitafterdiscount - $expense) }}</h3>
                </div>

            </div>


        </div>
    </div>
</div>
