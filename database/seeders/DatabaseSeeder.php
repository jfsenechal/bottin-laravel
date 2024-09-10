<?php

namespace Database\Seeders;

use App\Models\Fiche;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user = User::factory()
            ->create([
                'name' => 'Test User',
                'email' => env('LOGIN_USER_DEFAULT'),
                'password' => Hash::make(env('LOGIN_PWD_DEFAULT')),
            ]);
        Fiche::factory()
            ->create([
                'societe' => 'AfmLibre',
                'slug' => 'afm-libre',
            ]);
    }
}
