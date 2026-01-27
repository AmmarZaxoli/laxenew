    <div wire:poll.10s="fetchCount" style="display: inline-block;">
        <!--[if BLOCK]><![endif]--><?php if($count > 0): ?>
            <span class="badge rounded-pill bg-danger" 
                  style="font-size: 0.7rem; padding: 0.35em 0.65em; margin-left: 5px;">
                <?php echo e($count); ?>

            </span>
        <?php else: ?>
            <span class="badge rounded-pill bg-secondary" style="font-size: 0.6rem; opacity: 0.5;">0</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div><?php /**PATH C:\Users\PC\Desktop\laxe8-10\storage\framework\views/a23bbe63546a849c52e9fa459af4d7ed.blade.php ENDPATH**/ ?>