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
            'first_name' => 'Dondo',
            'last_name' => 'Dano',
            'email' => 'test@spamast.edu.ph',
            'password' => bcrypt('password'),
            'user_role_id' => '1',
            'avatar' => 'https://ui-avatars.com/api/?background=random&size=128&rounded=true&bold=true&format=svg&name=Dondo+Dano'
        ]);

        \App\Models\Role::factory()->create([
            'role_nice' => 'admin',
            'role_definition' => 'Admin'
        ]);
        \App\Models\Role::factory()->create([
            'role_nice' => 'remis',
            'role_definition' => 'REMIS'
        ]);
        \App\Models\Role::factory()->create([
            'role_nice' => 'proponent',
            'role_definition' => 'Proponent'
        ]);
        \App\Models\Role::factory()->create([
            'role_nice' => 'research director',
            'role_definition' => 'Research Director'
        ]);
        \App\Models\Role::factory()->create([
            'role_nice' => 'extension director',
            'role_definition' => 'Extension Director'
        ]);
        \App\Models\Role::factory()->create([
            'role_nice' => 'planning officer',
            'role_definition' => 'Planning Officer'
        ]);
        \App\Models\Role::factory()->create([
            'role_nice' => 'budget officer',
            'role_definition' => 'Budget Office'
        ]);
        \App\Models\Role::factory()->create([
            'role_nice' => 'accounting officer',
            'role_definition' => 'Accounting Officer'
        ]);


        \App\Models\UserRole::factory()->create([
            'user_id' => 11,
            'role_id' => 1
        ]);
    }
}
