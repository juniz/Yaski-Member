<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class TransactionTable extends DataTableComponent
{
    protected $model = Transaction::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFiltersStatus(true);
    }

    public function builder(): Builder
    {
        return Transaction::query();
    }

    public function filters(): array
    {
        return [
            DateFilter::make('Tanggal Transaksi')
                ->filter(function (Builder $builder, string $value) {
                    $builder->whereDate('transaction.created_at', Date::parse($value)->format('Y-m-d'));
                }),
            SelectFilter::make('Status')
                ->options([
                    '' => 'Semua',
                    'hadir' => 'Hadir',
                    'tidak hadir' => 'Tidak hadir',
                ])
                ->filter(function (Builder $builder, $value) {
                    if ($value === '') {
                        return;
                    }
                    $builder->where('transaction.stts', $value);
                }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Workshop", "workshop.nama")
                ->sortable(),
            Column::make("Snap token", "snap_token")
                ->sortable(),
            Column::make("Nama", "nama")
                ->sortable(),
            Column::make("Jns kelamin", "jns_kelamin")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Telp", "telp")
                ->sortable(),
            Column::make("Nama rs", "nama_rs")
                ->sortable(),
            Column::make("Kd rs", "kd_rs")
                ->sortable(),
            Column::make("Kepemilikan rs", "kepemilikan_rs")
                ->sortable(),
            Column::make("Provinsi id", "provinsi_id")
                ->sortable(),
            Column::make("Kabupaten id", "kabupaten_id")
                ->sortable(),
            Column::make("Ukuran baju", "ukuran_baju")
                ->sortable(),
            Column::make("Paket", "paket")
                ->sortable(),
            Column::make("Harga", "harga")
                ->sortable()
                ->format(fn ($value, $row, Column $column) => number_format($value, 2, ',', '.')),
            Column::make("Stts", "stts")
                ->sortable()
                ->format(fn ($value, $row, Column $column) => $value == 'hadir' ? 'Hadir' : 'Tidak hadir'),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
