<?php $__env->startSection('css'); ?>
<style>
    .profile-users {
        background-image: url('<?php echo e(URL::asset("assets/images/fasyankes/".$fasyankes->image)); ?>');
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        margin: -24px -24px 23px -24px;
        padding: 140px 0px;
        position: relative;
    }

    .profile-users:after {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(30%, rgba(43, 57, 64, 0.5)), to(#2b3940));
        background: linear-gradient(to bottom, rgba(43, 57, 64, 0.5) 30%, #2b3940 100%);
        position: absolute;
        height: 100%;
        width: 100%;
        right: 0;
        bottom: 0;
        left: 0;
        top: 0;
        opacity: 0.5;
        content: "";
    }
</style>
<?php $__env->stopSection(); ?>

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
    <!--  Update Fasyankes -->
    <div class="modal fade update-fasyankes" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Data Fasyankes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-fasyankes">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" value="<?php echo e(Auth::user()->id); ?>" id="data_id">
                        <div class="mb-3">
                            <label for="kode">Kode Fasyankes</label>
                            <input type="text" value="<?php echo e($fasyankes->kode ?? ''); ?>"
                                class="form-control <?php $__errorArgs = ['kode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id='kode' name="kode"
                                autofocus>
                            <div class="text-danger" id="kodeError" data-ajax-feedback="kode"></div>
                        </div>
                        <div class="mb-3">
                            <label for="nama">Nama Fasyankes</label>
                            <input type="text" value="<?php echo e($fasyankes->nama ?? ''); ?>" class=" form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id='nama' name="nama">
                            <div class="text-danger" id="namaError" data-ajax-feedback="nama"></div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label font-size-13 text-muted">Jenis</label>
                            <select class="form-control <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" data-trigger name="jenis"
                                id="jenis" placeholder="Jenis Fasyankes">
                                <option value="">Pilih jenis</option>
                                <?php $__currentLoopData = $jenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($j); ?>" <?php if($fasyankes->jenis == $j): ?> selected <?php endif; ?>><?php echo e($j); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="text-danger" id="jenisError" data-ajax-feedback="jenis"></div>
                        </div>

                        <div class="mb-3">
                            <label for="kelas">Kelas</label>
                            <select type="text" value="<?php echo e($fasyankes->kelas ?? ''); ?>"
                                class="form-control <?php $__errorArgs = ['kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" data-trigger id='kelas'
                                name="kelas">
                                <option value="">Pilih kelas</option>
                                <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k); ?>" <?php if($fasyankes->kelas == $k): ?> selected <?php endif; ?>><?php echo e($k); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="text-danger" id="kelasError" data-ajax-feedback="kelas"></div>
                        </div>

                        <div class="mb-3">
                            <label for="telp">Telp</label>
                            <input type="text" value="<?php echo e($fasyankes->telp ?? ''); ?>"
                                class="form-control <?php $__errorArgs = ['telp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id='telp' name="telp">
                            <div class="text-danger" id="telpError" data-ajax-feedback="telp"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" value="<?php echo e($fasyankes->email ?? ''); ?>"
                                class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id='email' name="email">
                            <div class="text-danger" id="emailError" data-ajax-feedback="email"></div>
                        </div>

                        <div class="mb-3">
                            <label for="direktur">Nama Direktur</label>
                            <input type="text" value="<?php echo e($fasyankes->direktur ?? ''); ?>" class="form-control <?php $__errorArgs = ['direktur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id='direktur' name="direktur">
                            <div class="text-danger" id="direkturError" data-ajax-feedback="telp"></div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="provinsi" class="form-label font-size-13 text-muted">Provinsi</label>
                                <select class="form-control" data-trigger name="provinsi" id="provinsi"
                                    placeholder="Cari Provinsi">
                                    <option value="">Pilih provinsi</option>
                                    <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($province->id); ?>"><?php echo e($province->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="text-danger" id="provinsiError" data-ajax-feedback="provinsi"></div>
                            </div>
                        </div>

                        <div class="col-12 kabupaten-form">
                            <div class="mb-3">
                                <label for="kabupaten" class="form-label font-size-13 text-muted">Kabupaten /
                                    Kota</label>
                                <select class="form-control" name="kabupaten" id="kabupaten"
                                    placeholder="Cari Kabupaten">
                                </select>
                                <div class="text-danger" id="kabupatenError" data-ajax-feedback="kabupaten"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat">Alamat Fasyankes</label>
                            <textarea type="text" class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id='alamat'
                                name="alamat" cols="3"><?php echo e($fasyankes->alamat ?? ''); ?>

                    </textarea>
                            <div class="text-danger" id="alamatError" data-ajax-feedback="alamat"></div>
                        </div>

                        <div class="mb-3">
                            <label for="image">Profile Fasyankes</label>
                            <div class="input-group">
                                <input type="file" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="image"
                                    name="image" autofocus>
                                <label class="input-group-text" for="image">Upload</label>
                            </div>
                            <div class="text-start mt-2">
                                <img src="<?php if(!empty($fasyankes->image)): ?><?php echo e(URL::asset('assets/images/fasyankes/'. $fasyankes->image)); ?><?php else: ?><?php echo e(URL::asset('assets/images/profile-bg-1.jpg')); ?><?php endif; ?>"
                                    alt="" class="rounded me-2" width="200" data-holder-rendered="true">
                            </div>
                            <div class="text-danger" role="alert" id="imageError" data-ajax-feedback="image"></div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile"
                                data-id="<?php echo e(Auth::user()->id); ?>" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<?php $__env->startSection('script'); ?>
<script>
    window.addEventListener('openUpdateFasyankesModal', event => {
        $("#update-fasyankes").modal('show');
    })

    window.addEventListener('closeUpdateFasyankesModal', event => {
        $("#update-fasyankes").modal('hide');
    })
</script>
<?php $__env->stopSection(); ?><?php /**PATH /Users/hardiko/Documents/Developer/LARAVEL/Dason-Laravel_v1.0.0/Admin/resources/views/livewire/profile/body.blade.php ENDPATH**/ ?>