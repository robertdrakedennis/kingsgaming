<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateRolesAndAssignRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'banned']);

        $role = Role::create(['name' => 'Administrator']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'User']);
        $role->givePermissionTo('create posts');

        $role = Role::create(['name' => 'Banned']);
        $role->givePermissionTo('banned');
    }
}
