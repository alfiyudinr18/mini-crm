<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $companyIds = DB::table('companies')->pluck('id')->toArray();

        foreach (range(1, 15) as $i) {
            DB::table('employes')->insert([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'company_id' => $faker->randomElement($companyIds),
                'email'      => $faker->safeEmail,
                'phone'      => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
