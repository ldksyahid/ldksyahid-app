<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use App\Models\MsKtaldksyahid; // Adjust the model name to match your application.

class MsKTALDKSyahidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        foreach (range(1, 101) as $index) { // Adjust range to the number of records you want to seed.
            MsKtaldksyahid::create([
                'fullName' => $faker->name,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'nim' => $faker->unique()->randomNumber(8),
                'faculty' => $faker->word,
                'major' => $faker->word,
                'generation' => $faker->year,
                'memberNumber' => $faker->bothify('A######'),
                'lifeMotto' => $faker->sentence(6), // Change to sentence or desired length.
                'background' => $faker->text(200), // Adjust length as needed.
                'email' => $faker->email,
                'linkedIn' => $faker->url,
                'instagram' => $faker->userName,
                'photo' => $faker->imageUrl(200, 200, 'people'),
                'linkProfile' => $faker->url,
            ]);
        }
    }
}

