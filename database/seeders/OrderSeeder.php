<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['pending', 'delivered'];
        for ($i = 1; $i <= 20; $i++) {
            DB::table('orders')->insert([
                'user_id' => rand(1, 3),
                'status' => $statuses[array_rand($statuses)],
                'total' => rand(300000, 2000000),
                'customer_name' => 'Tuyết Nhi',
                'customer_email' => 'tnhi0' . rand(1,9) . '@gmail.com',
                'customer_phone' => '0912345678',
                'ordered_at' => Carbon::now()->subDays(rand(0, 60)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
