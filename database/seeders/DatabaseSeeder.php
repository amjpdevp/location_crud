<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /* *
     * Seed the application's database.
     *
     * @return void
    
    public function newrun()
    {
     \App\Models\User::factory(100)->create()->each(function($user) {
        $users = Sentinel::findById($user->id);
        $activation = Activation::create($users);
        Activation::complete($users,$activation->code); 
    }); } */
    
    

    public function run(){
        \App\Models\User::factory(10)->create()->each(function($user) {
            $users = Sentinel::findById($user->id);
            $activation = Activation::create($users);
            Activation::complete($users,$activation->code);
            DB::table('role_users')->insert([
                'user_id' => $user->id,
                'role_id' => rand(1,2),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
        
       \App\Models\Business::factory(10)->create();   
        \App\Models\Location::factory(10)->create();   

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class
        ]);
        }

}