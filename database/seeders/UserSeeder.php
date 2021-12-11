<?php

namespace Database\Seeders;

use App\Models\Role;
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
            'role_id' => Role::query()->where('name', 'Admin')->first('id')->id
        ]);
        User::factory(10)->create();
    }
}
