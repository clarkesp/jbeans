<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the 'admin' role exists before assigning it
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create the Admin user
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin1234'),
        ]);

        // Assign the 'admin' role to the user
        $user->assignRole($adminRole);

        // Create additional users using the factory
        User::factory(50)->create([
            'created_at' => function () {
                return now();
            },
        ]);
    }
}
