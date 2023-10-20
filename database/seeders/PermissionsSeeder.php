<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit courses']);
        Permission::create(['name' => 'delete courses']);
        Permission::create(['name' => 'edit guides']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'teacher']);
        $role1->givePermissionTo('edit courses');

        $role2 = Role::create(['name' => 'moderator']);
        $role2->givePermissionTo('edit courses');
        $role2->givePermissionTo('delete courses');


        $role3 = Role::create(['name' => 'admin']);
        $role3->givePermissionTo('edit courses');
        $role3->givePermissionTo('delete courses');
        $role3->givePermissionTo('edit guides');

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'test@ex.com',
            'password' => bcrypt('secret'),
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'moderator',
            'email' => 'moderator@ex.com',
            'password' => bcrypt('secret'),
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@ex.com',
            'password' => bcrypt('secret'),
        ]);
        $user->assignRole($role2);
        $user->assignRole($role3);
    }
}