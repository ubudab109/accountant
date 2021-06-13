<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'firstname' => 'User',
            'lastname' => 'Satu',
            'username' => 'user',
            'password' => Hash::make('123123123')
        ]);
    }
}
