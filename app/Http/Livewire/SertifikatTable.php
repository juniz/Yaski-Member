<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Sertifikat;

class SertifikatTable extends DataTableComponent
{
    protected $model = Sertifikat::class;
    public $idWorkshop;

    public function mount($idWorkshop)
    {
        $this->idWorkshop = $idWorkshop;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Sertifikat::query()
            ->join('peserta', 'peserta.id', '=', 'sertifikat.peserta_id')
            ->join('workshop', 'workshop.id', '=', 'sertifikat.workshop_id')
            ->where('workshop.id', $this->idWorkshop)
            ->select('sertifikat.*', 'peserta.nama', 'workshop.nama');
    }

    public function columns(): array
    {
        return [
            Column::make("No urut", "no_urut")
                ->sortable(),
            Column::make("Tgl Checkin", "created_at")
                ->sortable()
                ->sortable(),
            Column::make("No sertifikat", "no_sertifikat")
                ->sortable()
                ->searchable(),
            Column::make("Nama", "nama")
                ->sortable()
                ->searchable(),
            Column::make("Instansi", "instansi")
                ->sortable()
                ->searchable(),
            Column::make("File sertifikat", "file_sertifikat")
                ->sortable(),
        ];
    }
}
