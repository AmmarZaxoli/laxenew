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

        /* Modern Table Styles */
        .data-table-container {
            background: #fff;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 2.5rem;
            transition: var(--transition);
        }

        .data-table-container:hover {
            box-shadow: 0 12px 30px -6px rgba(20, 20, 20, 0.2);
        }

        .data-table-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 1.2rem 1.5rem;
            border-radius: var(--card-radius) var(--card-radius) 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .data-table-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .table-controls {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .table-search {
            position: relative;
        }

        .table-search input {
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 20px;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            font-size: 0.9rem;
            transition: var(--transition);
            width: 200px;
        }

        .table-search input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .table-search input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);

        }

        .table-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.95rem;
        }

        .modern-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: right;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 2px solid #e2e8f0;
            position: sticky;
            top: 0;
        }

        .modern-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
            transition: var(--transition);
            font-size: 16px;
        }

        .modern-table tbody tr {
            transition: var(--transition);

        }

        .modern-table tbody tr:hover {
            background-color: #f1f5f9;
        }

        .modern-table tbody tr:hover td {
            color: var(--dark);
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .page-item {
            display: flex;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            border-radius: 8px;
            padding: 0 0.5rem;
            border: 1px solid #e2e8f0;
            background: white;
            color: var(--secondary);
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
        }

        .page-link:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .table-info {
            color: var(--secondary);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .data-table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .table-controls {
                width: 100%;
                justify-content: space-between;
            }

            .table-footer {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .table-search input {
                width: 150px;
            }
        }
    </style>


    <div class="container-fluid py-4">
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
                            <input type="date" id="startdate" wire:model="startdate" class="form-control shadow-sm">
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

        <!-- Modern Table -->
        <div class="data-table-container">
            <div class="data-table-header">
                <h5><i class="bi bi-table me-2"></i> النتائج</h5>
                <div class="table-controls">
                    <div class="table-search">
                        <i class="bi bi-search"></i>
                        <input type="text" wire:model.live="searchTerm" placeholder="بحث في الجدول...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th wire:click="sortBy('name')" style="cursor: pointer" class="text-leght">الاسم
                                @if ($sortColumn == 'name')
                                    @if ($sortDirection == 'asc')
                                        <i class="bi bi-sort-alpha-down"></i> {{-- A→Z --}}
                                    @else
                                        <i class="bi bi-sort-alpha-down-alt"></i> {{-- Z→A --}}
                                    @endif
                                @else
                                    <i class="bi bi-arrow-down-up"></i> {{-- Default sort icon --}}
                                @endif
                            </th>
                            <th wire:click="sortBy('code')" style="cursor: pointer" class="text-center">
                                الكود
                                <i class="ms-1">
                                    @if ($sortColumn == 'code')
                                        @if ($sortDirection == 'asc')
                                            <i class="bi bi-sort-alpha-down"></i> {{-- A→Z --}}
                                        @else
                                            <i class="bi bi-sort-alpha-down-alt"></i> {{-- Z→A --}}
                                        @endif
                                    @else
                                        <i class="bi bi-arrow-down-up"></i> {{-- Default sort icon --}}
                                    @endif
                                </i>
                            </th>

                            <th class="text-center">الكمية المباعة</th>
                            <th class="text-center">الكمية الشراء</th>
                            <th class="text-center">الكمية المتوفرة</th>
                            <th class="text-center">سعر الشراء</th>
                            <th class="text-center">رقم الفاتورة</th>
                            <th class="text-center">اسم الفاتورة</th>
                            <th class="text-center">تاريخ الإنشاء</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($filteredResults as $filteredResult)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration + ($filteredResults->currentPage() - 1) * $filteredResults->perPage() }}
                                </td>
                                <td class="text-leght">{{ $filteredResult->name }}</td>
                                <td class="text-center">{{ $filteredResult->code }}</td>
                                <td class="text-center">{{ $filteredResult->q_sold }}</td>
                                <td class="text-center">{{ $filteredResult->quantity }}</td>
                                <td class="text-center"  style="font-weight: bold; ">{{ $filteredResult->quantity - $filteredResult->q_sold}}</td>
                                <td class="text-center">{{ number_format($filteredResult->buy_price) ?? '-' }}</td>
                                <td class="text-center">{{ $filteredResult->buy_invoice->num_invoice }}</td>
                                <td class="text-center">{{ $filteredResult->buy_invoice->name_invoice }}</td>
                                <td class="text-center">{{ $filteredResult->buy_invoice->datecreate->format('Y-m-d') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">لا توجد نتائج</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Laravel Livewire Pagination -->
                <div class="table-info" style="padding: 15px">


                    {{ $filteredResults->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
