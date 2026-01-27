    <div wire:poll.15s="fetchCount" style="display: inline-block;">
        <!--[if BLOCK]><![endif]--><?php if($count > 0): ?>
            <span class="badge rounded-pill bg-danger" 
                  style="font-size: 0.75rem; padding: 0.35em 0.65em; margin-left: 5px;">
                <?php echo e($count); ?>

            </span>
        <?php else: ?>
            <span class="badge rounded-pill bg-secondary" style="font-size: 0.6rem; opacity: 0.3;">0</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div><?php /**PATH C:\Users\PC\Desktop\laxe8-10\storage\framework\views/15edb1c0672f694d58670b6ce1d0a390.blade.php ENDPATH**/ ?>