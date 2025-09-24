
<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Database Backup & Restore</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Create Backup</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('backup')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download Database Backup (GZipped)
                </button>
                <small class="text-muted d-block mt-2">This will create a compressed backup of your database.</small>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Restore Backup</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('restore')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="sql_file" class="form-label">Select Backup File</label>
                    <input type="file" name="sql_file" id="sql_file" class="form-control" required>
                    <div class="form-text">Accepted formats: .sql or .sql.gz (compressed)</div>
                </div>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-upload"></i> Restore Database
                </button>
                <div class="alert alert-warning mt-3">
                    <strong>Warning:</strong> This will overwrite your current database. Make sure you have a backup.
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\backuplist\create.blade.php ENDPATH**/ ?>