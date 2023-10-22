<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use App\Models\MsKtaldksyahid; // Sesuaikan nama model dengan yang ada di aplikasi Anda.

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

        foreach (range(1, 101) as $index) { // Sesuaikan range dengan jumlah data yang ingin Anda seeding.
            MsKtaldksyahid::create([
                'fullName' => $faker->name,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'nim' => $faker->unique()->randomNumber(8),
                'faculty' => $faker->word,
                'major' => $faker->word,
                'generation' => $faker->year,
                'memberNumber' => $faker->bothify('A######'),
                'lifeMotto' => $faker->sentence(6), // Ubah ke sentence atau panjang yang Anda inginkan.
                'background' => $faker->text(200), // Ubah panjangnya sesuai kebutuhan.
                'email' => $faker->email,
                'linkedIn' => $faker->url,
                'instagram' => $faker->userName,
                'photo' => $faker->imageUrl(200, 200, 'people'),
                'linkProfile' => $faker->url,
            ]);
        }
    }
}

