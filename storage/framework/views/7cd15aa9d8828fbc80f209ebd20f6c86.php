<div>
   <div class="cart">
     <h5>Payment Information for Invoice #<?php echo e($invoiceId); ?></h5>

    <!--[if BLOCK]><![endif]--><?php if($invoice): ?>
        <p>Customer: <?php echo e($invoice->customer_name); ?></p>
        <p>Total: <?php echo e($invoice->total_price); ?></p>
    <?php else: ?>
        <p>Invoice not found.</p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
   </div>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/invoices/payment-invoice.blade.php ENDPATH**/ ?>