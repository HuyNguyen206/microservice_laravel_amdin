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
        $this->call(UserSeeder::class);
        $this->call(RolePermissionSeeder::class);
        Product::factory(30)->create();

        Order::factory(10)->hasOrderItems(random_int(2,5))->create();
    }
}
