

<?php $__env->startSection('content'); ?>

  <div class="card body formtype">
    <div class="header d-flex justify-content-between align-items-center mb-1">
    <a data-bs-toggle="modal" data-bs-target="#insertModal" class="btn btn-outline-success">إضافة مصروف</a>
    </div>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('expenses.show', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1000503255-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
  </div>



  <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="insertModalLabel">إضافة مصروف</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="غلاق"></button>
      </div>
      <div class="modal-body">

      <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('expenses.insert', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1000503255-1', $__slots ?? [], get_defined_vars());

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
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/expenses/create.blade.php ENDPATH**/ ?>