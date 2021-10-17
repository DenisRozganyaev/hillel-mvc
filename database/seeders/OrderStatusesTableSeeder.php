<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = Config::get('constants.db.order_status');
        foreach ($statuses as $key => $status) {
            OrderStatus::create(['name' => $status]);
        }
    }
}
