<?php

use App\Role;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permission = new \App\Permission();
        $permission->name="manage-everything";
        $permission->display_name="Manage Everything";
        $permission->description="Manager has permission on everything";
        $permission->save();


        $permission = new \App\Permission();
        $permission->name="client-everything";
        $permission->display_name="Client Everything";
        $permission->description="Client has permission on everything";
        $permission->save();

    }
}
