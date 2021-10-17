<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Faker\Provider\en_US\PhoneNumber;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $role = Role::where(
            'name',
            '=',
            Config::get('constants.db.roles.customer')
        )->first();


        return [
            'role_id' => $role->id,
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastName,
            'birthdate' => $this->faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => $this->faker->password(8),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
