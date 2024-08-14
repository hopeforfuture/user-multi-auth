<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<1;$i++) {
            User::create(
                [
                    'name'              => fake()->name(),
                    'email'             => fake()->unique()->safeEmail(),
                    'password'          => Hash::make('test123'),
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'remember_token'    => Str::random(10),
                ]
            );
        }
    }
}
