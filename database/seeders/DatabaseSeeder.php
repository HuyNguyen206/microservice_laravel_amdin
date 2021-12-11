<?php

namespace Database\Seeders;

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
        Role::query()->insert([
            [
                'name' => 'Admin'
            ],
            [
                'name' => 'Editor'
            ],
            [
                'name' => 'Viewer'
            ]
        ]);
        $this->call(UserSeeder::class);
        Product::factory(30)->create();
    }
}
