<?php

use App\Account;
use App\Balance;
use App\Role;
use App\User;
use Database\Seeders\AccountSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RolesTableSeeder::class);
    }
}
