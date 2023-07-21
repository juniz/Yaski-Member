<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="card-title text-uppercase mb-0"><?php echo e($fasyankes->nama ?? 'Data Fasyankes Kosong'); ?>

                </h4>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target=".update-fasyankes"><i class="bx bx-plus me-1"></i><?php if(empty($fasyankes)): ?>
                    Tambah Fasyankes <?php else: ?> Ubah
                    Fasyankes <?php endif; ?></button>
            </div>
        </div>

        <div class="card-body">
            <?php if(!empty($fasyankes)): ?>
            <div>
                <div class="pb-3">
                    <h5 class="font-size-15">Kode :</h5>
                    <div class="text-muted">
                        <p class="mb-2"><?php echo e($fasyankes->kode); ?></p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Jenis Fasyankes :</h5>
                    <div class="text-muted">
                        <p><?php echo e($fasyankes->jenis); ?></p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Kelas :</h5>
                    <div class="text-muted">
                        <p><?php echo e($fasyankes->kelas); ?></p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Telp :</h5>
                    <div class="text-muted">
                        <p><?php echo e($fasyankes->telp); ?></p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Email :</h5>
                    <div class="text-muted">
                        <p><?php echo e($fasyankes->email); ?></p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Direktur :</h5>
                    <div class="text-muted">
                        <p><?php echo e($fasyankes->direktur); ?></p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Alamat :</h5>
                    <div class="text-muted">
                        <p><?php echo e($fasyankes->alamat); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>

<?php $__env->startSection('script'); ?>
<script>
    window.addEventListener('openUpdateFasyankesModal', event => {
        $("#update-fasyankes").modal('show');
    })

    window.addEventListener('closeUpdateFasyankesModal', event => {
        $("#update-fasyankes").modal('hide');
    })
</script><?php /**PATH /Users/hardiko/Documents/Developer/LARAVEL/Dason-Laravel_v1.0.0/Admin/resources/views/livewire/profile/body.blade.php ENDPATH**/ ?>