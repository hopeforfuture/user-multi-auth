<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<500;$i++) {
            Lead::create([
                    'name'        => fake()->name(),
                    'email'       => fake()->unique()->safeEmail(),
                    'password'    => Hash::make('test123'),
                    'address'     => fake()->address(),
                    'customer_id' => Customer::all()->random()->id,
            ]);
        }
    }
}
