<?php

namespace Database\Seeders;

use App\Account;
use App\Balance;
use App\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $roleId = $user->roles[0]->id;
            $phoneLastTwoDigits = substr($user->phone_number, -2);
            $userIdDigits = str_pad($user->id, 4, '0', STR_PAD_LEFT);

            $accountNumber = $roleId . rand(10, 99) . $phoneLastTwoDigits . $userIdDigits;

            $account = Account::create([
                'user_id' => $user->id,
                'account_number' => $accountNumber,
            ]);

            Balance::create([
                'account_id' => $account->id,
                'balance' => rand(100, 10000),
            ]);
        }
    }
}
