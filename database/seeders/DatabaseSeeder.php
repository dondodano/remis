<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
<<<<<<< HEAD
<<<<<<< HEAD
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'user_role' => 'super',
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
            'first_name' => 'Dondo',
            'last_name' => 'Dano',
            'email' => 'test@spamast.edu.ph',
            'password' => bcrypt('password'),
            'user_role' => 'super',
            'avatar' => 'https://ui-avatars.com/api/?background=random&size=128&rounded=true&bold=true&format=svg&name=Dondo+Dano'
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
        ]);
    }
}
