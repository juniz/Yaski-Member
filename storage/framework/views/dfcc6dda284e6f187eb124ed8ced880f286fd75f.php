<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Profile'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/libs/choices.js/choices.js.min.css')); ?>" rel="stylesheet">
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
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="profile-users" style="height: 300px">
        </div>
    </div>
</div>

<div class="row">
    <div class="profile-content">
        <div class="row align-items-end">
            <div class="col-sm">
                <div class="d-flex align-items-end mt-3 mt-sm-0">
                    <div class="flex-shrink-0">
                        <div class="avatar-xxl me-3">
                            <img src="<?php if($user->avatar != ''): ?><?php echo e(URL::asset('images/'. $user->avatar)); ?> <?php else: ?> <?php echo e(URL::asset('assets/images/users/avatar-1.png')); ?> <?php endif; ?>"
                                alt="profile-image" class="img-fluid rounded-circle d-block img-thumbnail">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div>
                            <h5 class="font-size-16 mb-1"><?php echo e($user->name); ?></h5>
                            <p class="text-muted font-size-13 mb-2 pb-2"><?php echo e($user->email); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="d-flex align-items-start justify-content-end gap-2 mb-2">
                    <div>
                        
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target=".update-profile"><i class="me-1"></i> Ubah Profile</button>

                    </div>
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-link font-size-16 shadow-none text-muted dropdown-toggle"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-dots-horizontal-rounded font-size-20"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card bg-transparent shadow-none">
            <div class="card-body">
                <ul class="nav nav-tabs-custom card-header-tabs border-top mt-2" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab">Overview</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-8">
        <div class="tab-content">
            <div class="tab-pane active" id="overview" role="tabpanel">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.body', [])->html();
} elseif ($_instance->childHasBeenRendered('ZzqpALc')) {
    $componentId = $_instance->getRenderedChildComponentId('ZzqpALc');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZzqpALc');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZzqpALc');
} else {
    $response = \Livewire\Livewire::mount('profile.body', []);
    $html = $response->html();
    $_instance->logRenderedChild('ZzqpALc', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                
            </div>
            <!-- end tab pane -->

            
            <!-- end tab pane -->
        </div>
        <!-- end tab content -->
    </div>
    <!-- end col -->

    <div class="col-xl-4 col-lg-4">

        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="card-title mb-0">Team Members</h5>
                    <a href="<?php echo e(route('sub-users.create')); ?>" class="btn btn-sm btn-secondary"><i
                            class="bx bx-plus me-1"></i> Tambah </a>
                </div>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <tbody>
                            <?php $__currentLoopData = $subUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>

                                <td style="width: 50px;"><img src="<?php echo e(URL::asset('images/avatar/'. $subUser->avatar)); ?>"
                                        class="rounded-circle avatar-sm" alt=""></td>
                                <td>
                                    <h5 class="font-size-14 m-0"><a href="javascript: void(0);" class="text-dark"><?php echo e($subUser->name); ?></a></h5>
                                </td>
                                <td>
                                    <div>
                                        <a href="javascript: void(0);"
                                            class="badge bg-soft-primary text-primary font-size-11">Frontend</a>
                                        <a href="javascript: void(0);"
                                            class="badge bg-soft-primary text-primary font-size-11">UI</a>
                                    </div>
                                </td>
                                <td>
                                    <i class="mdi mdi-circle-medium font-size-18 text-success align-middle me-1"></i>
                                    Online
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Weekly Hours</h5>
            </div>
            <div class="card-body">
                <div id="overview-chart" data-colors='["#1c84ee"]' class="apex-charts" dir="ltr"></div>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Skills</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2 font-size-16">
                    <a href="#" class="badge badge-soft-primary">Photoshop</a>
                    <a href="#" class="badge badge-soft-primary">illustrator</a>
                    <a href="#" class="badge badge-soft-primary">HTML</a>
                    <a href="#" class="badge badge-soft-primary">CSS</a>
                    <a href="#" class="badge badge-soft-primary">Javascript</a>
                    <a href="#" class="badge badge-soft-primary">Php</a>
                    <a href="#" class="badge badge-soft-primary">Python</a>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->
<!--  Update Profile example -->
<div class="modal fade update-profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Ubah Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-profile">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" value="<?php echo e(Auth::user()->id); ?>" id="data_id">
                    <div class="mb-3">
                        <label for="useremail" class="form-label">Email</label>
                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="useremail"
                            value="<?php echo e(Auth::user()->email); ?>" name="email" placeholder="Enter email" autofocus>
                        <div class="text-danger" id="emailError" data-ajax-feedback="email"></div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            value="<?php echo e(Auth::user()->name); ?>" id="username" name="name" autofocus
                            placeholder="Enter username">
                        <div class="text-danger" id="nameError" data-ajax-feedback="name"></div>
                    </div>
                    <div class="mb-3">
                        <label for="avatar">Profile Picture</label>
                        <div class="input-group">
                            <input type="file" class="form-control <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="avatar"
                                name="avatar" autofocus>
                            <label class="input-group-text" for="avatar">Upload</label>
                        </div>
                        <div class="text-start mt-2">
                            <img src="<?php if(Auth::user()->avatar != ''): ?><?php echo e(URL::asset('images/'. Auth::user()->avatar)); ?><?php else: ?><?php echo e(URL::asset('assets/images/users/avatar-1.png')); ?><?php endif; ?>"
                                alt="" class="rounded-circle avatar-lg">
                        </div>
                        <div class="text-danger" role="alert" id="avatarError" data-ajax-feedback="avatar"></div>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light UpdateProfile"
                            data-id="<?php echo e(Auth::user()->id); ?>" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
unset($__errorArgs, $__bag); ?>" id='kode' name="kode" autofocus>
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
                            <label for="kabupaten" class="form-label font-size-13 text-muted">Kabupaten / Kota</label>
                            <select class="form-control" name="kabupaten" id="kabupaten" placeholder="Cari Kabupaten">
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/choices.js/choices.js.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/profile.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/form-advanced.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<script type="text/javascript">
    $('#update-profile').on('submit', function(event) {
        event.preventDefault();
        var Id = $('#data_id').val();
        let formData = new FormData(this);
        $('#emailError').text('');
        $('#nameError').text('');
        $('#avatarError').text('');
        $.ajax({
            url: "<?php echo e(url('update-profile')); ?>" + "/" + Id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#emailError').text('');
                $('#nameError').text('');
                $('#avatarError').text('');
                if (response.isSuccess == false) {
                    alert(response.Message);
                } else if (response.isSuccess == true) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(response) {
                $('#emailError').text(response.responseJSON.errors.email);
                $('#nameError').text(response.responseJSON.errors.name);
                $('#avatarError').text(response.responseJSON.errors.avatar);
            }
        });
    });

    $('#update-fasyankes').on('submit', function(event) {
        event.preventDefault();
        var Id = $('#data_id').val();
        let formData = new FormData(this);
        $('#kodeError').text('');
        $('#namaError').text('');
        $('#jenisError').text('');
        $('#kelasError').text('');
        $('#telpError').text('');
        $('#emailError').text('');
        $('#direkturError').text('');
        $('#alamatError').text('');
        $('#provinsiError').text('');
        $('#kabupatenError').text('');
        $('#imageError').text('');
        $.ajax({
            url: "<?php echo e(url('update-fasyankes')); ?>" + "/" + Id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.isSuccess == false) {
                    alert(response.Message);
                } else if (response.isSuccess == true) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(response) {
                $('#nameError').text(response.responseJSON.errors.name);
                $('#kodeError').text(response.responseJSON.errors.kode);
                $('#jenisError').text(response.responseJSON.errors.jenis);
                $('#kelasError').text(response.responseJSON.errors.kelas);
                $('#telpError').text(response.responseJSON.errors.telp);
                $('#emailError').text(response.responseJSON.errors.email);
                $('#direkturError').text(response.responseJSON.errors.direktur);
                $('#alamatError').text(response.responseJSON.errors.alamat);
                $('#provinsiError').text(response.responseJSON.errors.provinsi);
                $('#kabupatenError').text(response.responseJSON.errors.kabupaten);
                $('#imageError').text(response.responseJSON.errors.image);
            }
        });
    });

    const query_task = new Choices('#kabupaten', {
            removeItemButton: true,
            searchPlaceholderValue: 'Pilih Kabupaten / Kota', 
            placeholder: true,
        });
        query_task.passedElement.element.addEventListener('addItem', () => reset(), false);
        query_task.passedElement.element.addEventListener('removeItem', () => reset(), false);

        function reset(id) {
            query_task.clearChoices();
            query_task.setChoices(function() { 
                return fetch( 
                    "<?php echo e(url('get-kabupaten')); ?>" + "/" + id
                ) 
                .then(function(response) { 
                    return response.json(); 
                }) 
                .then(function(data) { 
                    return data.map(function(response) { 
                        return { label: response.name, value: response.id }; 
                    }); 
                }); 
            });
        }

        $("#provinsi").on('change', function() {
            let id = $(this).val();
            query_task.removeActiveItems();
            reset(id);
        });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/hardiko/Documents/Developer/LARAVEL/Dason-Laravel_v1.0.0/Admin/resources/views/profile/index.blade.php ENDPATH**/ ?>