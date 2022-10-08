<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $rand_user = User::inRandomOrder()->value('id');
        return [
            'name'=>fake()->Company,
            'email'=>fake()->email,
            'address'=>fake()->address,
            'user_id'=>$rand_user,
        ];
    }
}
