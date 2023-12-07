<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $enumToArray = UserRole::cases();
        $userRoles = array_column($enumToArray, 'value');

<<<<<<< HEAD
<<<<<<< HEAD
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'user_role' => $userRoles[rand(1,8)],
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        $nameWithSpace = $firstName.' '.$lastName;
        $nameWithPlus = str_replace(' ', '+', $nameWithSpace);


        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => preg_replace('/@example\..*/', '@'. config('app.email_domain'), fake()->unique()->safeEmail),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'user_role' => $userRoles[rand(1,8)],
            'avatar' => 'https://ui-avatars.com/api/?background=random&size=128&rounded=true&bold=true&format=svg&name='.$nameWithPlus,
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
            'remember_token' => Str::random(10),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
