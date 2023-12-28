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
               'email'=> 'admin@ldksyah.id',
               'password'=> bcrypt('admin'),
            ]
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
