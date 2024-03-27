<?php

namespace App\Invoice;

use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class TransactionMember
{
    public function generateInvoice($data)
    {
        $client = new Party([
            'name'          => 'Yayasan SIMRS Khanza Indonesia',
            'phone'         => '+6282138143546',
            'address'       => 'PERUMAHAN BUNGA LESTARI D 15',
        ]);

        $customer = new Buyer([
            'name'          => $data['costumer']['name'],
            'phone'         => $data['costumer']['phone'],
            'custom_fields'  => [
                'email' => $data['costumer']['email'],
            ]
        ]);
        $items = [];
        foreach ($data['product'] as $product) {
            $items[] = InvoiceItem::make($product['name'])
                ->description($product['description'])
                ->pricePerUnit($product['price'])
                ->quantity($product['quantity']);
        }

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make($data['invoice_name'])
            ->series($data['order_id'])
            // ability to include translated invoice status
            // in case it was paid
            ->status(__('invoices::invoice.paid'))
            // ->sequence(667)
            ->serialNumberFormat('{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now())
            ->dateFormat('d/m/Y')
            // ->payUntilDays(14)
            // ->currencySymbol('$')
            // ->currencyCode('USD')
            // ->currencyFormat('{SYMBOL}{VALUE}')
            // ->currencyThousandsSeparator('.')
            // ->currencyDecimalPoint(',')
            ->filename($data['file_name'])
            ->addItems($items)
            // ->notes($notes)
            ->logo(public_path('assets/images/logo.png'))
            // You can additionally save generated invoice to configured disk
            ->save('invoices');

        return $invoice;
    }
}
