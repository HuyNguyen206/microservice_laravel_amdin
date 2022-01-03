<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
//        $this->call(RolePermissionSeeder::class);
//        $this->call(UserSeeder::class);
        Product::factory(100)->create();
//        $this->call(OrderAndOrderItemSeeder::class);
    }
}
