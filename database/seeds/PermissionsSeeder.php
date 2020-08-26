<?php

declare(strict_types = 1);

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Class PermissionsSeeder
 * @author Kristo Leas <kristo.leas@gmail.com>
 */
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    // Reset cached roles and permissions
	    app()[PermissionRegistrar::class]->forgetCachedPermissions();
	
	    // create permissions
	    Permission::create(['name' => 'edit posts']);
	    Permission::create(['name' => 'delete posts']);
	    Permission::create(['name' => 'publish posts']);
	    Permission::create(['name' => 'unpublish posts']);
	
	    // create roles and assign existing permissions
	    $role1 = Role::create(['name' => 'writer']);
	    $role1->givePermissionTo('edit posts');
	    $role1->givePermissionTo('delete posts');
	
	    $role2 = Role::create(['name' => 'admin']);
	    $role2->givePermissionTo('publish posts');
	    $role2->givePermissionTo('unpublish posts');
	
	    $role3 = Role::create(['name' => 'super-admin']);
	    // gets all permissions via Gate::before rule; see AuthServiceProvider
    }
}
