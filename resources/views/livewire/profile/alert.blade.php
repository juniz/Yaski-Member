<div wire:init='load'>
    @if(!$isProfileComplete)
    <div class="card border border-warning mb-3">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h5 class="card-title mb-1">Kelengkapan Profil</h5>
                    <p class="text-muted mb-0">Lengkapi data fasyankes dan PIC agar semua layanan dapat digunakan.</p>
                </div>
                <span class="badge bg-warning text-dark font-size-13">{{ $completionProgress }}%</span>
            </div>

            <div class="progress mb-3" style="height: 10px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $completionProgress }}%;" aria-valuenow="{{ $completionProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <div class="row g-3">
                @foreach($completionItems as $item)
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-between border rounded p-3 h-100">
                            <div class="d-flex align-items-center">
                                <span class="avatar-xs me-2">
                                    <span class="avatar-title rounded-circle bg-soft-{{ $item['complete'] ? 'success' : 'warning' }} text-{{ $item['complete'] ? 'success' : 'warning' }}">
                                        <i class="bx {{ $item['complete'] ? 'bx-check' : 'bx-time-five' }}"></i>
                                    </span>
                                </span>
                                <div>
                                    <h6 class="mb-0">{{ $item['label'] }}</h6>
                                    <small class="text-muted">{{ $item['complete'] ? 'Sudah lengkap' : 'Belum lengkap' }}</small>
                                </div>
                            </div>

                            @if(!$item['complete'] && $item['action'] == 'fasyankes')
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target=".update-fasyankes">
                                    Lengkapi
                                </button>
                            @elseif(!$item['complete'] && $item['action'] == 'pic')
                                <button type="button" class="btn btn-sm btn-primary" wire:click="openPicModal">
                                    Lengkapi
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('message'))
    <div class="alert alert-{{ Session::get('type') }} alert-dismissible alert-label-icon label-arrow fade show"
        role="alert">
        <i class="bx bxs-info-circle label-icon"></i><span id="daftar-workshop-btn"><strong>{!! Session::get('message') !!}</strong></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        @if(Session::get('type') == 'info')
        {{-- <button type="button" wire:click='$emit("openModalWorkshop", {{$workshop_id}})' class="btn btn-primary">Daftar</button> --}}
        <a href="{{  url('/workshop/detail/'.$slug) }}" type="button" class="btn btn-primary">Daftar Sekarang</a>
        @endif
    </div>
    @endif
</div>
