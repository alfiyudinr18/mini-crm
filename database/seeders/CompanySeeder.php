<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();

        foreach (range(1, 15) as $i) {
            DB::table('companies')->insert([
                'name'       => $faker->company,
                'email'      => $faker->companyEmail,
                'logo'       => null,
                'website'    => $faker->url,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
