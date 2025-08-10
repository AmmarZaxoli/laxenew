<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم المتطورة</title>
    <!-- Bootstrap 5 RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    @livewireStyles
</head>

<body>

    <!-- Topbar -->
    <nav class="topbar">
        <button class="btn btn-link text-dark d-lg-none" type="button" id="sidebarToggle">
            <i class="bi bi-list fs-3"></i>
        </button>
    </nav>

    <!-- Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Modern Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Sidebar Brand -->
        <div class="sidebar-brand">
            <div class="brand-content">
                <div class="logo-icon">
                    <i class="bi bi-columns-gap"></i>
                </div>
            </div>
            <button class="sidebar-toggler d-none d-lg-block" type="button">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <div class="sidebar-nav">
            <!-- Dashboard Section -->
            <div class="nav-group">
                <div class="nav-group-title">الرئيسية</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('dashboards.create') ? 'active' : '' }}"
                            href="{{ route('dashboards.create') }}">
                            <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                            <span class="nav-text">لوحة التحكم</span>
                            <span class="nav-badge">New</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('getAPI.create') ? 'active' : '' }}"
                            href="{{ route('getAPI.create') }}">
                            <span class="nav-icon"><i class="bi bi-cart-plus"></i></span>
                            <span class="nav-text">GET API</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('selling.create') ? 'active' : '' }}"
                            href="{{ route('selling.create') }}">
                            <span class="nav-icon"><i class="bi bi-cart-plus"></i></span>
                            <span class="nav-text">بيع المنتجات</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Management Section -->
            <div class="nav-group">
                <div class="nav-group-title">الإدارة</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('driver.create', 'driver.*') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse" href="#driversMenu" role="button"
                            aria-expanded="{{ Route::is('driver.create', 'driver.*') ? 'true' : 'false' }}">
                            <span class="nav-icon"><i class="bi bi-truck"></i></span>
                            <span class="nav-text">إدارة السوائق</span>
                            <span class="nav-arrow"><i class="bi bi-chevron-left"></i></span>
                        </a>
                        <div class="collapse {{ Route::is('driver.create', 'driver.*') ? 'show' : '' }}"
                            id="driversMenu">
                            <ul class="submenu">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('driver.create') ? 'active' : '' }}"
                                        href="{{ route('driver.create') }}">
                                        <span class="nav-text">إضافة سائق</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('invoice_control.create', 'invoice_control.*') ? 'active' : '' }}"
                            href="{{ route('invoice_control.create') }}">
                            <span class="nav-icon"><i class="bi bi-cash-coin"></i></span>
                            <span class="nav-text">دفع الديون</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('returnsell.create', 'returnsell.*') ? 'active' : '' }}"
                            href="{{ route('returnsell.create') }}">
                            <span class="nav-icon"><i class="bi bi-file-earmark-text"></i></span>
                            <span class="nav-text">إرجاع الفواتير</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('expenses.create', 'expenses.*') ? 'active' : '' }}"
                            href="{{ route('expenses.create') }}">
                            <span class="nav-icon"><i class="bi bi-wallet2"></i></span>
                            <span class="nav-text">مصروفات</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('companys.create') ? 'active' : '' }}"
                            href="{{ route('companys.create') }}">
                            <span class="nav-icon"><i class="bi bi-buildings"></i></span>
                            <span class="nav-text">إضافة شركة</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('accounts.create', 'accounts.*') ? 'active' : '' }}"
                            href="{{ route('accounts.create') }}">
                            <span class="nav-icon"><i class="bi bi-person-plus"></i></span>
                            <span class="nav-text">الحسابات</span>
                        </a>
                    </li>

                    <!-- Products Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('types.create', 'products.create', 'definitions.create') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse" href="#productsMenu" role="button"
                            aria-expanded="{{ Route::is('types.create', 'products.create', 'definitions.create') ? 'true' : 'false' }}">
                            <span class="nav-icon"><i class="bi bi-box-seam"></i></span>
                            <span class="nav-text">إدارة المنتجات</span>
                            <span class="nav-arrow"><i class="bi bi-chevron-left"></i></span>
                        </a>
                        <div class="collapse {{ Route::is('types.create', 'products.create', 'definitions.create') ? 'show' : '' }}"
                            id="productsMenu">
                            <ul class="submenu">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('products.create') ? 'active' : '' }}"
                                        href="{{ route('products.create') }}">
                                        <span class="nav-text">المخزن</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('types.create') ? 'active' : '' }}"
                                        href="{{ route('types.create') }}">
                                        <span class="nav-text">إدارة الأنواع</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('definitions.create') ? 'active' : '' }}"
                                        href="{{ route('definitions.create') }}">
                                        <span class="nav-text">تعريف المنتجات</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Invoices Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('add_Invoices.create') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse" href="#invoicesMenu" role="button"
                            aria-expanded="{{ Route::is('add_Invoices.create') ? 'true' : 'false' }}">
                            <span class="nav-icon"><i class="bi bi-currency-dollar"></i></span>
                            <span class="nav-text">شراء القوائم</span>
                            <span class="nav-arrow"><i class="bi bi-chevron-left"></i></span>
                        </a>
                        <div class="collapse {{ Route::is('add_Invoices.create') ? 'show' : '' }}" id="invoicesMenu">
                            <ul class="submenu">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('add_Invoices.create') ? 'active' : '' }}"
                                        href="{{ route('add_Invoices.create') }}">
                                        <span class="nav-text">إضافة القوائم</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('add_Invoices.create') ? 'active' : '' }}"
                                        href="{{ route('show_Invoices.create') }}">
                                        <span class="nav-text">عرض القوائم</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Offers Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('offers.create') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse" href="#offersMenu" role="button"
                            aria-expanded="{{ Route::is('offers.create') ? 'true' : 'false' }}">
                            <span class="nav-icon"><i class="bi bi-gift"></i></span>
                            <span class="nav-text">إدارة العروضات</span>
                            <span class="nav-arrow"><i class="bi bi-chevron-left"></i></span>
                        </a>
                        <div class="collapse {{ Route::is('offers.create') ? 'show' : '' }}" id="offersMenu">
                            <ul class="submenu">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('offers.create') ? 'active' : '' }}"
                                        href="{{ route('offers.create') }}">
                                        <span class="nav-text">إنشاء العروض</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('offers.edit') ? 'active' : '' }}"
                                        href="{{ route('offers.edit') }}">
                                        <span class="nav-text">تعديل العروض</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- System Section -->
            <div class="nav-group">
                <div class="nav-group-title">النظام</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#settingsMenu" role="button"
                            aria-expanded="false">
                            <span class="nav-icon"><i class="bi bi-gear"></i></span>
                            <span class="nav-text">الإعدادات</span>
                            <span class="nav-arrow"><i class="bi bi-chevron-left"></i></span>
                        </a>
                        <div class="collapse" id="settingsMenu">
                            <ul class="submenu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('backup.index') }}">
                                        <span class="nav-text">إعدادات الموقع</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    {{-- <div class="user-name">{{ Auth::guard('account')->user()->name }}</div>
                    <small class="text-muted">{{ Auth::guard('account')->user()->role }}</small> --}}
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    @livewire('drivers.drivers-order')
    @livewireScripts
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('print-driver-invoices', async ({
                url
            }) => {
                try {
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = url;
                    document.body.appendChild(iframe);

                    iframe.onload = function() {
                        setTimeout(() => {
                            iframe.contentWindow.focus();
                            iframe.contentWindow.print();

                            setTimeout(() => {
                                document.body.removeChild(iframe);
                            }, 500);
                        }, 500);
                    };
                } catch (error) {
                    console.error('Print failed:', error);
                    alert('حدث خطأ أثناء الطباعة. الرجاء المحاولة مرة أخرى.');
                }
            });
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('print-invoices', async (url) => {
                try {
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = url;
                    document.body.appendChild(iframe);

                    iframe.onload = function() {
                        setTimeout(() => {
                            iframe.contentWindow.focus();
                            iframe.contentWindow.print();

                            setTimeout(() => {
                                document.body.removeChild(iframe);
                            }, 500);
                        }, 500);
                    };
                } catch (error) {
                    console.error('Print failed:', error);
                    alert('حدث خطأ أثناء الطباعة. الرجاء المحاولة مرة أخرى.');
                }
            });
        });
    </script>
</body>

</html>
