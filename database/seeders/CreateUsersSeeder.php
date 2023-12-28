<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'MyDios',
               'email'=>'yusufwijaya3@gmail.com',
               'password'=> bcrypt('ldk110692'),
            ]
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
