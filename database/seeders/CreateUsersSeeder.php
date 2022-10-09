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
               'name'=>'Admin LDK Syahid',
               'email'=>'ldk@uinjkt.ac.id',
                'is_admin'=>'1',
               'password'=> bcrypt('bismillahldk26'),
            ],
            [
                'name'=>'Yusuf Wijaya',
                'email'=>'yusufwijaya3@gmail.com',
                'is_admin'=>'1',
                'password'=> bcrypt('ldk110692'),
            ],
            [
               'name'=>'User',
               'email'=>'user@itsolutionstuff.com',
                'is_admin'=>'0',
               'password'=> bcrypt('123456'),
            ],
            [
                'name'=>'User2',
                'email'=>'user2@gmail.com',
                 'is_admin'=>'0',
                'password'=> bcrypt('123456'),
            ]
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
