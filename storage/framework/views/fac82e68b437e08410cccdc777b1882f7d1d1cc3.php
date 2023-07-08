<div>
    <?php if(Session::has('message')): ?>
    <div class="alert alert-<?php echo e(Session::get('type')); ?> alert-dismissible alert-label-icon label-arrow fade show"
        role="alert">
        <i class="mdi mdi-block-helper label-icon"></i><strong><?php echo e(Session::get('message')); ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
</div><?php /**PATH /Users/hardiko/Documents/Developer/LARAVEL/Dason-Laravel_v1.0.0/Admin/resources/views/components/alert.blade.php ENDPATH**/ ?>