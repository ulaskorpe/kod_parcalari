<?php

use App\Permission;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//
		$role = new \App\Role();
		$role->name = "manager";
		$role->display_name = "Manager";
		$role->description = "Manager is allowed to manage and edit everything";

		$role->save();
		$role->attachPermission(Permission::where('name', '=', 'manage-everything')->first());

		$role = new \App\Role();
		$role->name = "client";
		$role->display_name = "Client";
		$role->description = "Client is allowed to manage and edit everything";
		$role->save();
		$role->attachPermission(Permission::where('name', '=', 'client-everything')->first());


        $role = new \App\Role();
        $role->name = "driver";
        $role->display_name = "Driver";
        $role->description = "...";
        $role->is_department=1;
        $role->save();
        $role->attachPermission(Permission::where('name', '=', 'client-everything')->first());
    }
}
