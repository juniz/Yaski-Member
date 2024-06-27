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
            ->where('sertifikat.nama', '!=', null)
            ->select('sertifikat.*', 'peserta.nama', 'workshop.nama');
    }

    public function columns(): array
    {
        return [
            Column::make("No urut", "no_urut")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('no_urut', $direction);
                }),
            Column::make("Tgl Checkin", "created_at")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('created_at', $direction);
                }),
            Column::make("No sertifikat", "no_sertifikat")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('no_sertifikat', $direction);
                })
                ->searchable(),
            Column::make("Nama", "nama")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('peserta.nama', $direction);
                })
                ->searchable(),
            Column::make("Instansi", "instansi")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('peserta.instansi', $direction);
                })
                ->searchable(),
            Column::make("File sertifikat", "file_sertifikat"),
        ];
    }
}
