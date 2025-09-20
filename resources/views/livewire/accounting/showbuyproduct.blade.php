<div>
    <head>
        
    <link rel="stylesheet" href="{{ asset('assets/css/styleaccountingcreate.css') }}" />
    </head>


    <div class="container-fluid py-4">
       

     
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
