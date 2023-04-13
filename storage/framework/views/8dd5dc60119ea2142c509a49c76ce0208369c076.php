<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('tester.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('tester::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\standardization\Modules/Tester\Resources/views/index.blade.php ENDPATH**/ ?>