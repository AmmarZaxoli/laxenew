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
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" />

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

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
                        <a class="nav-link <?php echo e(Route::is('dashboards.create') ? 'active' : ''); ?>"
                            href="<?php echo e(route('dashboards.create')); ?>">
                            <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                            <span class="nav-text">لوحة التحكم</span>
                            <span class="nav-badge">New</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('getAPI.create') ? 'active' : ''); ?>"
                            href="<?php echo e(route('getAPI.create')); ?>">
                            <span class="nav-icon"><i class="bi bi-cart-plus"></i></span>
                            <span class="nav-text">GET API</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('selling.create') ? 'active' : ''); ?>"
                            href="<?php echo e(route('selling.create')); ?>">
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
                        <a class="nav-link <?php echo e(Route::is('driver.create', 'driver.*') ? '' : 'collapsed'); ?>"
                            data-bs-toggle="collapse" href="#driversMenu" role="button"
                            aria-expanded="<?php echo e(Route::is('driver.create', 'driver.*') ? 'true' : 'false'); ?>">
                            <span class="nav-icon"><i class="bi bi-truck"></i></span>
                            <span class="nav-text">إدارة السوائق</span>
                            <span class="nav-arrow"><i class="bi bi-chevron-left"></i></span>
                        </a>
                        <div class="collapse <?php echo e(Route::is('driver.create', 'driver.*') ? 'show' : ''); ?>"
                            id="driversMenu">
                            <ul class="submenu">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(Route::is('driver.create') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('driver.create')); ?>">
                                        <span class="nav-text">إضافة سائق</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('invoice_control.create', 'invoice_control.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('invoice_control.create')); ?>">
                            <span class="nav-icon"><i class="bi bi-cash-coin"></i></span>
                            <span class="nav-text">دفع الديون</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('returnsell.create', 'returnsell.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('returnsell.create')); ?>">
                            <span class="nav-icon"><i class="bi bi-file-earmark-text"></i></span>
                            <span class="nav-text">إرجاع الفواتير</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('expenses.create', 'expenses.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('expenses.create')); ?>">
                            <span class="nav-icon"><i class="bi bi-wallet2"></i></span>
                            <span class="nav-text">مصروفات</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('print.create', 'print.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('print.create')); ?>">
                            <span class="nav-icon"><i class="bi bi-printer"></i></span>
                            <span class="nav-text">طباعة القوائم</span>
                        </a>

                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('companys.create') ? 'active' : ''); ?>"
                            href="<?php echo e(route('companys.create')); ?>">
                            <span class="nav-icon"><i class="bi bi-buildings"></i></span>
                            <span class="nav-text">إضافة شركة</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('accounts.create', 'accounts.*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('accounts.create')); ?>">
                            <span class="nav-icon"><i class="bi bi-person-plus"></i></span>
                            <span class="nav-text">الحسابات</span>
                        </a>
                    </li>

                    <!-- Products Management -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('types.create', 'products.create', 'definitions.create') ? '' : 'collapsed'); ?>"
                            data-bs-toggle="collapse" href="#productsMenu" role="button"
                            aria-expanded="<?php echo e(Route::is('types.create', 'products.create', 'definitions.create') ? 'true' : 'false'); ?>">
                            <span class="nav-icon"><i class="bi bi-box-seam"></i></span>
                            <span class="nav-text">إدارة المنتجات</span>
                            <span class="nav-arrow"><i class="bi bi-chevron-left"></i></span>
                        </a>
                        <div class="collapse <?php echo e(Route::is('types.create', 'products.create', 'definitions.create') ? 'show' : ''); ?>"
                            id="productsMenu">
                            <ul class="submenu">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(Route::is('products.create') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('products.create')); ?>">
                                        <span class="nav-text">المخزن</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(Route::is('types.create') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('types.create')); ?>">
                                        <span class="nav-text">إدارة الأنواع</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(Route::is('definitions.create') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('definitions.create')); ?>">
                                        <span class="nav-text">تعريف المنتجات</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Invoices Management -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('add_Invoices.create') ? '' : 'collapsed'); ?>"
                            data-bs-toggle="collapse" href="#invoicesMenu" role="button"
                            aria-expanded="<?php echo e(Route::is('add_Invoices.create') ? 'true' : 'false'); ?>">
                            <span class="nav-icon"><i class="bi bi-currency-dollar"></i></span>
                            <span class="nav-text">شراء القوائم</span>
                            <span class="nav-arrow"><i class="bi bi-chevron-left"></i></span>
                        </a>
                        <div class="collapse <?php echo e(Route::is('add_Invoices.create') ? 'show' : ''); ?>" id="invoicesMenu">
                            <ul class="submenu">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(Route::is('add_Invoices.create') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('add_Invoices.create')); ?>">
                                        <span class="nav-text">إضافة القوائم</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(Route::is('add_Invoices.create') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('show_Invoices.create')); ?>">
                                        <span class="nav-text">عرض القوائم</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Offers Management -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::is('offers.create') ? '' : 'collapsed'); ?>"
                            data-bs-toggle="collapse" href="#offersMenu" role="button"
                            aria-expanded="<?php echo e(Route::is('offers.create') ? 'true' : 'false'); ?>">
                            <span class="nav-icon"><i class="bi bi-gift"></i></span>
                            <span class="nav-text">إدارة العروضات</span>
                            <span class="nav-arrow"><i class="bi bi-chevron-left"></i></span>
                        </a>
                        <div class="collapse <?php echo e(Route::is('offers.create') ? 'show' : ''); ?>" id="offersMenu">
                            <ul class="submenu">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(Route::is('offers.create') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('offers.create')); ?>">
                                        <span class="nav-text">إنشاء العروض</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(Route::is('offers.edit') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('offers.edit')); ?>">
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
                                    <a class="nav-link" href="<?php echo e(route('backup.index')); ?>">
                                        <span class="nav-text">إعدادات الموقع</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                        <li class="nav-item">
                    <a class="nav-link text-danger" href="#" onclick="confirmLogout()">
                        <span class="nav-icon"><i class="bi bi-box-arrow-left"></i></span>
                        <span class="nav-text">تسجيل الخروج</span>
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
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
                    <div class="user-name"><?php echo e(Auth::guard('account')->user()->name); ?></div>
                    <small class="text-muted"><?php echo e(Auth::guard('account')->user()->role); ?></small>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('drivers.drivers-order');

$__html = app('livewire')->mount($__name, $__params, 'lw-3794699385-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('print-driver-invoices', async ({ url }) => {
                try {
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = url;
                    document.body.appendChild(iframe);

                    iframe.onload = function () {
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

                    iframe.onload = function () {
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
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'تأكيد تسجيل الخروج',
                text: 'هل أنت متأكد أنك تريد تسجيل الخروج؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، سجل خروج',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the logout form
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html><?php /**PATH C:\Users\Malta Computer\Desktop\laxe8-17login\resources\views/layouts/index.blade.php ENDPATH**/ ?>