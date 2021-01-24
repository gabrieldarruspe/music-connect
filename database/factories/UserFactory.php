<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'oauth_providers' => null,
        ];
    }

    public function withSpotifyAccount()
    {
        return $this->state(function (array $attributes) {
            return [
                'oauth_providers' => [
                    'spotify' => [
                        'access_token' => 'BQAm8RDKkEXyIgvsupYchOYOc0kvbZVzAECc1Zg1zHSd2yL81aKG6876lHw0CEYy9NA1ybcGXcq4dSA80h_krtyvnIus7oJfwPeHdUnkRXNndiZj8VuGLDvcFXVHBfq-5rOaGdLxOql3bwD3aMdyIBP9qU1KTUJEQ4cd_Xx5eryV',
                    ],
                ],
            ];
        });
    }
}
