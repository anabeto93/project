<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin@admin.com';
        $password = 'password';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->command->info("User credentials are : ");
        $this->command->warn("Email: ". $email);
        $this->command->warn("Password: ".$password);
    }
}
