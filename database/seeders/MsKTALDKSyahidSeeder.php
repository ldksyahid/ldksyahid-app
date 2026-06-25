<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use App\Models\MsKtaldksyahid;
use App\Models\LkFaculty; // Import model ini
use App\Models\LkMajor;   // Import model ini
use App\Models\LkGeneration; // Import model ini

class MsKTALDKSyahidSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();
        
        // Ambil ID yang ada supaya tidak error foreign key
        $facultyIds = LkFaculty::pluck('id')->toArray();
        $majorIds = LkMajor::pluck('id')->toArray();
        $genIds = LkGeneration::pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            MsKtaldksyahid::create([
                'fullName'     => $faker->name,
                'gender'       => $faker->randomElement(['Male', 'Female']),
                'nim'          => $faker->unique()->randomNumber(8),
                
                // Gunakan ID (integer) bukan string
                'facultyID'    => !empty($facultyIds) ? $faker->randomElement($facultyIds) : 1,
                'majorID'      => !empty($majorIds) ? $faker->randomElement($majorIds) : 1,
                'generationID' => !empty($genIds) ? $faker->randomElement($genIds) : 1,
                
                'memberNumber' => $faker->bothify('A######'),
                'slogan'       => $faker->sentence(6), 
                'background'   => $faker->text(200), 
                'email'        => $faker->email,
                'linkedIn'     => $faker->url,
                'instagram'    => $faker->userName,
                'photo'        => 'default.jpg',
                'linkProfile'  => $faker->url,
            ]);
        }
    }
}