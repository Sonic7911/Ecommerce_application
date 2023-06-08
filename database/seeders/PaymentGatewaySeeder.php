<?php

namespace Database\Seeders;

use App\Models\Payment_Gateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment_Gateway::create([
            'name'=>"Cash On Delivery",
            'code'=>'cod',
        ]);

        Payment_Gateway::create([
            'name'=>"Khalti",
            'code'=>'khalti',
        ]);
    }
}
