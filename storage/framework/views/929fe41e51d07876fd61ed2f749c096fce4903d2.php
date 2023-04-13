<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('book.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('book::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\standardization\Modules/Book\Resources/views/index.blade.php ENDPATH**/ ?>