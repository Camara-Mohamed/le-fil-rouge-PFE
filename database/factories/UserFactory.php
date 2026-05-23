<?php

namespace Database\Factories;

use App\Enums\Diets;
use App\Enums\Provinces;
use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = [
            UserRoles::ARRIVANT,
            UserRoles::ANIMATEUR_1,
            UserRoles::ANIMATEUR_2,
            UserRoles::BREVETE,
            UserRoles::COORDINATEUR,
            UserRoles::FORMATEUR,
            UserRoles::ADMIN,
        ];

        $status = [
            UserStatus::INCOMPLETE,
            UserStatus::PENDING,
            UserStatus::COMPLETE,
        ];

        $provinces = [
            Provinces::ANVERS,
            Provinces::BRABANT_WALLON,
            Provinces::BRUXELLES,
            Provinces::FLANDRE_OCCIDENTALE,
            Provinces::FLANDRE_ORIENTALE,
            Provinces::HAINAUT,
            Provinces::LIEGE,
            Provinces::LIMBOURG,
            Provinces::LUXEMBOURG,
            Provinces::NAMUR,
            Provinces::BRABANT_FLAMAND,
        ];

        $diets = [
            Diets::NORMAL,
            Diets::VEGETARIAN,
            Diets::VEGAN,
            Diets::HALAL,
            Diets::KOSHER,
            Diets::GLUTEN_FREE,
            Diets::LACTOSE_FREE,
            Diets::OTHER,
        ];

        $email = Str::ascii(fake()->userName().'@lefilrouge.com');

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => strtolower($email),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('change_this'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement($roles),
            'status' => fake()->randomElement($status),
            'phone' => fake()->unique()->phoneNumber(),
            'birth_date' => fake()->dateTimeBetween('-44 years', '-18 years'),
            'address' => fake()->streetName(),
            'number' => fake()->buildingNumber(),
            'city' => fake()->city(),
            'province' => fake()->randomElement($provinces),
            'postal_code' => fake()->postcode(),
            'diet' => fake()->randomElement($diets),
            'allergies' => fake()->text(),
            'avatar_path' => null,
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
