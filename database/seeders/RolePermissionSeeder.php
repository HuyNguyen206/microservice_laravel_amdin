<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view_users',
            'edit_users',
            'view_roles',
            'edit_roles',
            'view_products',
            'edit_products',
            'view_orders',
            'edit_orders',

        ];
        // create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        // create roles and assign created permissions
        // this can be done as separate statements
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $editorRole = Role::create(['name' => 'Editor']);
        foreach ($permissions as $permission) {
            if ($permission === 'edit_roles') {
                continue;
            }
            $editorRole->givePermissionTo($permission);
        }
        $viewerRole = Role::create(['name' => 'Viewer']);
        foreach ($permissions as $permission) {
            if (str_contains($permission, 'view')) {
                $viewerRole->givePermissionTo($permission);
            }
        }

        $users = User::all();
        $users->each(function ($user){
            if ($user->email === "nguyenlehuyuit@gmail.com") {
                $user->assignRole('Admin');
            } else {
                $user->assignRole(Arr::random(['Admin', 'Viewer', 'Editor']));
            }
        });

    }
}
