<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    @if($workshop)
                    <div class="row mb-3">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-3 col-sm-5 col-md-4 mb-sm-7">
                                    <img src="{{url('storage/workshop/'.$workshop->gambar)}}" class="img-thumbnail" alt="{{$workshop->nama}}">
                                </div>
                                <div class="col-lg-9 col-sm-7 col-md-8 pt-3 pl-xl-4 pl-lg-5 pl-sm-4">
                                    <h2>{{ $workshop->nama }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center pt-5">
                            <span class="text-muted d-block mb-2">Terbuka Hingga:</span>
                            <b>{{ \Carbon\Carbon::parse($workshop->tgl_selesai)->isoFormat('LL') }}</b>
                            <span class="text-muted d-block mt-3 mb-2">Sisa Kuota:</span>
                            <b>{{$workshop->kuota}} peserta</b>
                        </div>
                    </div>
                    <div class="row border-top pt-3">
                        <div class="col-lg-9 order-lg-1 order-2 col-lg-push-3 pr-lg-5">
                            <h3>Deskripsi</h3>
                            <div class="fr-view mb-5">
                                {!! $workshop->deskripsi !!}
                            </div>
                        </div>
                        <div class="col-lg-3 order-lg-2 order-1 pl-lg-4 mb-5 event-info">
    
                            <div class="mb-5">
                                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">Daftar</button> --}}
                                @auth
                                <button type="button" class="btn btn-primary" wire:click='$emit("openModalWorkshop", {{$workshop->id}})'>Daftar</button>
                                @else
                                <a type="button" class="btn btn-primary" href="{{ route('pendaftaran.index', \Crypt::encrypt($workshop->id)) }}">Daftar</a>
                                @endauth
                            </div>
    
    
                            <div class="mb-5">
                            <div class="text-for-element">Jadwal Pelaksanaan</div>
                            <div class="row">
                                <div class="col-sm-3">Mulai</div>
                                <div class="col-sm-9">: <b>{{ \Carbon\Carbon::parse($workshop->tgl_mulai)->isoFormat('LL') }}</b></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">Selesai</div>
                                <div class="col-sm-9">: <b>{{ \Carbon\Carbon::parse($workshop->tgl_selesai)->isoFormat('LL') }}</b></div>
                            </div>
                            </div>
                            <div class="mb-5">
                            <div class="text-for-element">Lokasi</div>
                            <div class="row">
                                <div class="col-sm-2"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="col-sm-10">
                                    <b>{!! $workshop->lokasi !!}</b>
                                </div>
                            </div>
                            </div>
    
                        </div>
                    </div>
                    @else
                    <h3 class="text-center">Workshop Kosong</h3>
                    @endif
                    {{-- <div class="mt-3">
                        <div class="timer" x-data="timer(new Date().setDate(new Date().getDate() + 1))" x-init="init();">
                            <h1 x-text="time().days"></h1>
                            <h1 x-text="time().hours"></h1>
                            <h1 x-text="time().minutes"></h1>
                            <h1 x-text="time().seconds"></h1>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
<div wire:ignore.self class="modal fade orderdetailsModal" tabindex="-1" role="dialog" aria-labelledby=orderdetailsModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="orderdetailsModalLabel">Detail Pemesanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{-- <p class="mb-2">Product id: <span class="text-primary">#SK2540</span></p>
            <p class="mb-4">Billing Name: <span class="text-primary">Neal Matthews</span></p> --}}

            <div class="table-responsive">
                <table class="table align-middle table-nowrap">
                    <thead>
                        <tr>
                            <th style="width:40%" scope="col">Nama</th>
                            <th style="width:30%" class="text-center" scope="col">Jml</th>
                            <th style="width:30%" scope="col">Harga</th>
                        </tr>
                    </thead>
                    <tbody x-data="{ total : @entangle('total') }">
                        @foreach($workshop->paket as $paket)
                        <tr x-data="{ jml : 0, harga : '{{$paket->harga}}', tot : 0, nama : '{{$paket->nama}}' }">
                            <td>
                                <div>
                                    <h5 class="text-truncate font-size-14">{{$paket->nama}}</h5>
                                    <p class="text-muted mb-0">Rp {{$paket->harga}} x <span x-text="jml"></span></p>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-row gap-2">
                                    <button type="button" @click="[jml = jml > 0 ? jml-1 : jml, $wire.kurangTotal(harga,nama,jml)]" class="btn btn-lg"><i class="bx bx-minus-circle"></i></button>
                                    <span class="my-auto" x-text="jml"></span>
                                    <button @click="[jml++, $wire.tambahTotal(harga,nama,jml)]" class="btn btn-lg"><i class="bx bx-plus-circle"></i></button>
                                </div>
                            </td>
                            <td>Rp. <span class="rupiah" x-text="tot = harga * jml"></span></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">
                                <h6 class="m-0 text-right">Total:</h6>
                            </td>
                            <td>
                                Rp. <span x-text="total"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-grid">
                    <button type="button" class="btn btn-primary" wire:click='simpan'>Pesan</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div><!-- /.modal -->
</div>
