<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
            ],
            [
                'id'    => 2,
                'title' => 'Gudang',
            ],
            [
                'id'    => 3,
                'title' => 'Outlet',
            ],
            [
                'id'   => 4,
                'title' => 'Finance',
            ],
            [
                'id'   => 5,
                'title' => 'Customer',
            ],
            [
                'id'   => 6,
                'title' => 'Investor',
            ]
        ];


        foreach ($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }
    }
}
