<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(
            [
                "name" => "admin",
                "permissions" => '["create", "read", "update", "delete"]',
            ]

        );
        Role::create(
            [
                "name" => "property_owner",
                "permissions" => '["create", "read", "update", "delete"]',
            ]
        );
        Role::create(
            [
                "name" => "property_manager",
                "permissions" => '["create", "read", "update", "delete"]',
            ]
        );
        Role::create(
            [
                "name" => "tenant",
                "permissions" => '["read"]',
            ],
        );
        Role::create(
            [
                "name" => "user",
                "permissions" => '["read"]',
            ],
        );

        User::create(
            [
                'full_name' => 'Super Duper Admin',
                'name' => 'admin',
                'email' => 'admin@example.com',
                'phone' => '2911334',
                'birthdate' => '1999-01-01',
                'password' => bcrypt('password'),
                'role_id' => Role::where('name', 'admin')->first()->id,
                "status" => true,
            ]
        );

        User::create([
            'full_name' => 'Property Owner',
            'name' => 'owner',
            'email' => 'iwo@jkf.com',
            'phone' => '291 123 4312',
            'birthdate' => '1982-01-01',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'property_owner')->first()->id,
            "status" => true,
        ]);
        User::create([
            'full_name' => 'Property Manager',
            'name' => 'manager',
            'email' => 'jksd@jkkf.com',
            'phone' => '291 123 1029',
            'birthdate' => '2000-01-01',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'property_manager')->first()->id,
            "status" => true,
        ]);
        User::create([
            'full_name' => 'Tenant',
            'name' => 'tenant',
            'email' => 'jknsd@jks.com',
            'phone' => '291 123 091208',
            'birthdate' => '1914-01-01',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'tenant')->first()->id,
            "status" => true,
        ]);
        User::create([
            'full_name' => 'User',
            'name' => 'user',
            'email' => 'user@rmail.com',
            'phone' => '2931802',
            'birthdate' => '1992-01-01',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'user')->first()->id,
            "status" => true,
        ]);
    }
}
