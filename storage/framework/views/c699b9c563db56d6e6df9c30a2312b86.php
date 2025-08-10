

<?php $__env->startSection('content'); ?>
    <div class="card body formtype">
        <div class="header d-flex justify-content-between align-items-center mb-1">

            <a data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-outline-success">إضافة النوع</a>
        </div>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('types.show', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1604369182-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="padding: 10px">
                    <div class="modal-header">
                        <h4 class="modal-title" id="staticBackdropLabel">إنشاء النوع جديد</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('types.insert', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1604369182-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                </div>
            </div>
        </div>
    </div>

    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\types\create.blade.php ENDPATH**/ ?>