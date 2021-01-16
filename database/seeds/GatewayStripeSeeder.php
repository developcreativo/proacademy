<?php

use App\Models\Option;
use Illuminate\Database\Seeder;

class GatewayStripeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::create([
            'option' => 'gateway_stripe',
            'value' => true
        ]);
    }
}
