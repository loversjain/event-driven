<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
use Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<10; $i++) {
            User::create([
                    'name' => Str::random(10),
                    'email' => strtolower(Str::random(10)).'@gmail.com',
                    'password' => Hash::make('123'),
                ]);
            }
    }
}
