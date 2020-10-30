<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
        	[
        		'name' => 'role-list',
        		'display_name' => 'role-list',
        		'description' => 'See only Listing Of Role'
        	],
        	[
        		'name' => 'role-create',
        		'display_name' => 'role-create',
        		'description' => 'Create New Role'
        	],
        	[
        		'name' => 'role-edit',
        		'display_name' => 'role-edit',
        		'description' => 'Edit Role'
        	],
        	[
        		'name' => 'role-delete',
        		'display_name' => 'role-delete',
        		'description' => 'Delete Role'
        	],
        	[
        		'name' => 'Read',
        		'display_name' => 'Read',
        		'description' => 'See only Listing Of Item'
        	],
        	[
        		'name' => 'Create',
        		'display_name' => 'Create',
        		'description' => 'Create New Item'
        	],
        	[
        		'name' => 'Edit',
        		'display_name' => 'Edit',
        		'description' => 'Edit Item'
        	],
        	[
        		'name' => 'Delete',
        		'display_name' => 'Delete',
        		'description' => 'Delete Item'
        	]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
