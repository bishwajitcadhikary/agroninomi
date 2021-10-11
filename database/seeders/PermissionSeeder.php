<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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
        Permission::create(['name' => 'user_create']);
        Permission::create(['name' => 'user_read']);
        Permission::create(['name' => 'user_update']);
        Permission::create(['name' => 'user_delete']);
    }
}
