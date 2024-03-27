<div>
    @if(Session::has('message'))
    <div class="alert alert-{{ Session::get('type') }} alert-dismissible alert-label-icon label-arrow fade show"
        role="alert">
        <i class="bx bxs-info-circle label-icon"></i><strong>{!! Session::get('message') !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>