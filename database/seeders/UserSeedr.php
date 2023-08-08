<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeedr extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make("123456");
        User::query()->create([
            'name' => "مشعل الهندي",
            'email' => "admin@admin.com",
            "password" => "$password",
        ]);
    }
}
