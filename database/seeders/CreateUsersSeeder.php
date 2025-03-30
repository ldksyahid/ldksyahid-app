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
               'password'=> bcrypt('bismillahldk26'),
            ],
            [
                'name'=>'Yusuf Wijaya',
                'email'=>'yusufwijaya3@gmail.com',
                'password'=> bcrypt('ldk110692'),
            ],
            [
               'name'=>'User testing',
               'email'=>'usertesting@itsolutionstuff.com',
               'password'=> bcrypt('123456'),
            ]
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
