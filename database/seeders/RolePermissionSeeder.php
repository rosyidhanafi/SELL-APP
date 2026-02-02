<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $cashier = Role::firstOrCreate(['name' => 'cashier']);
        $system  = Role::firstOrCreate(['name' => 'system']);
        $user  = Role::firstOrCreate(['name' => 'user']);

        // Create Users
        $user1 = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        $user1->assignRole($admin);


        $user2 = User::firstOrCreate(
            ['email' => 'cashier1@example.com'],
            ['name' => 'Cashier User', 'password' => bcrypt('password')]
        );
        $user2->assignRole($cashier);

        $user3 = User::firstOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'User User', 'password' => bcrypt('password')]
        );
        $user3->assignRole($user);

        $user4 = User::firstOrCreate(
            ['email' => 'system@example.com'],
            ['name' => 'System User', 'password' => bcrypt('password')]
        );
        $user4->assignRole($system);

        $user5 = User::firstOrCreate(
            ['email' => 'cashier2@example.com'],
            ['name' => 'cashier2 User', 'password' => bcrypt('password')]
        );
        $user5->assignRole($cashier);
    }
}
