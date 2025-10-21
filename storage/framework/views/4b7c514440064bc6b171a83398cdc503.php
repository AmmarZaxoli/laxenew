

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('title', 'لوحة الحسابات'); ?>
    <div class="card body formtype">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('userpayment.show', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1360560823-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/userpayment/create.blade.php ENDPATH**/ ?>