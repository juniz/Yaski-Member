<div wire:init='load'>
    @if(Session::has('message'))
    <div class="alert alert-{{ Session::get('type') }} alert-dismissible alert-label-icon label-arrow fade show"
        role="alert">
        <i class="bx bxs-info-circle label-icon"></i><span id="daftar-workshop-btn"><strong>{!! Session::get('message') !!}</strong></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        @if(Session::get('type') == 'info')
        <button type="button" wire:click='$emit("openModalWorkshop", {{$workshop_id}})' class="btn btn-primary">Daftar</button>
        @endif
    </div>
    @endif
</div>
