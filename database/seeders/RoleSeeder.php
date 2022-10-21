<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        $roles = ['manager' => [
            'name' => 'manager',
            'permissions' => [
                'business.view' => true,
                'business.edit' => true,
                'business.delete' => true,
                'location.view' => true,
                'location.edit' => true,
                'location.delete' => true,
            ]   
        ],   
        'operator' => [
            'name' => 'operator',
            'permissions' => [
                'business.view' => true,
                'location.view' => true,
                'location.create' => true,
                'location.edit' => true,
                'location.delete' => true,
            ]   
            ],
            'admin' => [
                'name' => 'admin',
                'permissions' => [
                    'user.view' => true,
                    'user.edit' => true,
                    'user.delete' => true,
                    'business.view' => true,
                    'location.view' => true,
                    'location.edit' => true,
                    'location.delete' => true,
                ]   
            ]];

        foreach($roles as $role => $value){
            Sentinel::getRoleRepository()->createModel()->create([
                'name' => $role,
                'slug' => $role,
                'permissions' => $value['permissions'],
            ]);
        }

    }

}