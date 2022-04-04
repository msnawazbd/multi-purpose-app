<?php

namespace Database\Seeders;

use App\Models\InvoiceDetail;
use Illuminate\Database\Seeder;

class InvoiceDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = [
            [
                'invoice_id' => 1,
                'service_id' => 1,
                'quantity' => 1,
                'amount' => 5000,
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'invoice_id' => 1,
                'service_id' => 2,
                'quantity' => 1,
                'amount' => 35000,
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'invoice_id' => 2,
                'service_id' => 3,
                'quantity' => 1,
                'amount' => 25000,
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'invoice_id' => 2,
                'service_id' => 4,
                'quantity' => 1,
                'amount' => 12500,
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'invoice_id' => 3,
                'service_id' => 4,
                'quantity' => 1,
                'amount' => 12500,
                'status' => 1,
                'created_by' => 1,
            ],
            [
                'invoice_id' => 3,
                'service_id' => 5,
                'quantity' => 1,
                'amount' => 15500,
                'status' => 1,
                'created_by' => 1,
            ],
        ];

        foreach ($details as $key => $detail) {
            InvoiceDetail::query()->create($detail);
        }
    }
}
