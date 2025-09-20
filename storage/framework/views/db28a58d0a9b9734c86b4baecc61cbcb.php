

<?php $__env->startSection('content'); ?>
    <div style="padding: 10px">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('GetAPI.show', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3032234443-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\laxe8-10 (7)\resources\views\getAPI\create.blade.php ENDPATH**/ ?>