<div>
    <div wire:init='getWorkshop' class="card">
        <div class="card-body">
            <h5 class="card-title">Riwayat Workshop</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Workshop</th>
                            <th>Peserta</th>
                            <th>Biaya</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->workshop->nama }}</td>
                            <td>
                                <ul>
                                    @foreach($transaction->peserta as $peserta)
                                    <li>{{ $peserta->nama }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach($transaction->peserta as $peserta)
                                    <li>{{ $peserta->paket }} - {{ $peserta->harga }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            {{-- <td>
                                <button class="btn btn-primary waves-effect waves-light" wire:click='daftar({{ $workshop->id }})'>Daftar</button>
                            </td> --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
