    <div wire:poll.20s="fetchCount" style="display: inline-block;">
        <!--[if BLOCK]><![endif]--><?php if($count > 0): ?>
            <span class="badge rounded-pill bg-danger" style="font-size: 0.75rem;">
                <?php echo e($count); ?>

            </span>
        <?php else: ?>
            <span class="badge rounded-pill bg-secondary" style="opacity: 0.5;">0</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div><?php /**PATH C:\Users\PC\Desktop\laxe8-10\storage\framework\views/500ad9aec49dad41fe0edb03aedecae5.blade.php ENDPATH**/ ?>