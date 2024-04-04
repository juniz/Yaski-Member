<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Peserta;

class PesertaBatalTable extends DataTableComponent
{
    protected $model = Peserta::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nama", "nama")
                ->sortable(),
            Column::make("Jns kelamin", "jns_kelamin")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Telp", "telp")
                ->sortable(),
            Column::make("Transaction id", "transaction_id")
                ->sortable(),
            Column::make("Baju", "baju")
                ->sortable(),
            Column::make("Paket", "paket")
                ->sortable(),
            Column::make("Harga", "harga")
                ->sortable(),
            Column::make("Stts", "stts")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
