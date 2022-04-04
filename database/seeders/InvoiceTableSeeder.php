<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoices = [
            [
                'client_id' => 1,
                'invoice_no' => '0001',
                'invoice_date' => '2022-04-01',
                'invoice_due_date' => '2022-04-05',
                'total' => 40000,
                'paid' => 40000,
                'due' => 0,
                'description' => 'details..',
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'client_id' => 1,
                'invoice_no' => '0002',
                'invoice_date' => '2022-04-01',
                'invoice_due_date' => '2022-04-05',
                'total' => 37500,
                'paid' => 20000,
                'due' => 17500,
                'description' => 'details..',
                'status' => 2,
                'created_by' => 1,
            ],
            [
                'client_id' => 1,
                'invoice_no' => '0003',
                'invoice_date' => '2022-04-01',
                'invoice_due_date' => '2022-04-05',
                'total' => 28000,
                'paid' => 0,
                'due' => 28000,
                'description' => 'details..',
                'status' => 3,
                'created_by' => 1,
            ]
        ];

        foreach ($invoices as $key => $invoice) {
            Invoice::query()->create($invoice);
        }
    }
}
