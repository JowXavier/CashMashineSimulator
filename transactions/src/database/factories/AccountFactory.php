<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'agency' => $this->faker->randomNumber(3, false),
            'account' => $this->faker->randomNumber(5, false),
            'type' => $this->faker->randomElement(['POUPANCA', 'CORRENTE']),
            'balance' => $this->faker->randomFloat(5, 0, 20),
        ];
    }
}
