<div>
  

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
                    <h6>إجمالي المبيعات دين</h6>
                    <h3>{{ number_format($total - $totaldiscount) }}</h3>
                </div>


            

                <!-- Sales After Discount -->
                <div class="stat-card sales">
                    <div class="stat-icon">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>
                    <h6>المبيعات مستلمة</h6>
                    <h3>{{ number_format($totalafterdiscount) }}</h3>
                </div>

                

                <!-- Total Expenses -->
                <div class="stat-card expenses">
                    <div class="stat-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <h6>إجمالي المصروفات</h6>
                    <h3>{{ number_format($expense) }}</h3>
                </div>

           

                <!-- Net Profit -->
                <div class="stat-card net-profit">
                    <div class="stat-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h6>صافي الربح</h6>
                    <h3>{{ number_format($totalProfitafterdiscount - $expense) }}</h3>
                </div>


                    <!-- Total Discount -->
                <div class="stat-card discount">
                    <div class="stat-icon">
                        <i class="bi bi-percent"></i>
                    </div>
                    <h6>سندوق</h6>
                    <h3>{{ number_format($totalafterdiscount - $expense) }}</h3>
                </div>

            </div>


        </div>
    </div>
</div>
