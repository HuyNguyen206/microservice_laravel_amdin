<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'first_name' => 'huy',
            'last_name' => 'nguyen',
            'email' => 'nguyenlehuyuit@gmail.com',
        ]);
        User::factory(100)->create();
    }
}
