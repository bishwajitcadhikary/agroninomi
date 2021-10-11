<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'dashboard_read']);

        Permission::create(['name' => 'admin_create']);
        Permission::create(['name' => 'admin_read']);
        Permission::create(['name' => 'admin_update']);
        Permission::create(['name' => 'admin_delete']);

        Permission::create(['name' => 'client_create']);
        Permission::create(['name' => 'client_read']);
        Permission::create(['name' => 'client_update']);
        Permission::create(['name' => 'client_delete']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $client = Role::create(['name' => 'client']);
        $client->givePermissionTo(
            'dashboard_read'
        );

        $adminUser = User::create([
            "first_name" => "Admin",
            "last_name" => "User",
            "name" => "Admin User",
            "email" => "admin@agroninomi.test",
            "password" => bcrypt("password")
        ]);
        $adminUser->assignRole('admin');

        $clientUser = User::create([
            "first_name" => "Client",
            "last_name" => "User",
            "name" => "Client User",
            "email" => "client@agroninomi.test",
            "password" => bcrypt("password")
        ]);
        $clientUser->assignRole('client');
    }
}
