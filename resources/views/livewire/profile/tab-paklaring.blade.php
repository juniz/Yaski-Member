<div wire:init='cekPaklaring'>
    <ul class="nav nav-tabs-custom card-header-tabs border-top mt-2" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab">Profile
                Fasyankes</a>
        </li>
        @if($sttsPaklaring) 
        <li class="nav-item">
            <a class="nav-link px-3" data-bs-toggle="tab" id="paklaring-tab-btn" href="#paklaring-tabpanel" role="tab">Paklaring</a>
        </li> 
        @endif
        @if($sttsMou)
        <li class="nav-item">
            <a class="nav-link px-3" data-bs-toggle="tab" id="mou-tab-btn" href="#mou-tabpanel" role="tab">MOU</a>
        </li> 
        @endif
        <li class="nav-item">
            <a class="nav-link px-3" data-bs-toggle="tab" id="workshop-tab-btn" href="#workshop-tabpanel" role="tab">Riwayat Workshop</a>
        </li> 
    </ul>
</div>
