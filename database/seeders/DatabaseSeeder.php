<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Url;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = User::create([
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'name' => 'user',
        ]);

        for($i = 0; $i < 12; $i++) {
            $user->urls()->create([
                'original_url' => fake()->url(),
            ]);
        }


        $user = User::create([
            'email' => 'user2@gmail.com',
            'password' => Hash::make('password'),
            'name' => 'user2',
        ]);

        for($i = 0; $i < 12; $i++) {
            $user->urls()->create([
                'original_url' => fake()->url(),
            ]);
        }

        $urls = Url::all();
        foreach($urls as $url) {
            for ($i = 0;$i < rand(20,100);$i++) {
                $url->clicks()->create([
                    'ip_address' => fake()->ipv4(),
                    'created_at' => fake()->dateTimeBetween('-1 month'),
                ]);
            }
        }

    }
}
