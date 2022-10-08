<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        $rand_comapny = Business::inRandomOrder()->first();
       $user_id = $rand_comapny->user_id;
        $business_id = $rand_comapny->id;
        
        return [
            'name'=>fake()->city(),
            'email'=>fake()->email,
            'address'=>fake()->address,
            'user_id'=>$user_id,
            'business_id'=>$business_id,
        ];
    }
}
