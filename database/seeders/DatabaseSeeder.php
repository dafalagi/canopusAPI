<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ContentSeeder::class,
            DiscussSeeder::class,
            CommentSeeder::class,
            ReportSeeder::class,
            FavoriteSeeder::class,
        ]);

        User::create([
            'username' => 'dafalagi',
            'email' => 'dafa.unknown@gmail.com',
            'password' => Hash::make('password'),
            'bio' => 'admin',
            'is_admin' => true
        ]);
    }
}
