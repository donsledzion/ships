<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Marian',
            'email' => 'marian@sledziona.eu',
            'password' => Hash::make('secret'),
        ]);
        User::create([
            'name' => 'Kasia',
            'email' => 'kasia@margaryna.eu',
            'password' => Hash::make('secret'),
        ]);
        User::create([
            'name' => 'Krzysiu',
            'email' => 'krzysiu@gmail.eu',
            'password' => Hash::make('secret'),
        ]);
        User::create([
            'name' => 'Jagoda',
            'email' => 'jagoda@bush.org',
            'password' => Hash::make('secret'),
        ]);
        User::create([
            'name' => 'Wioletta',
            'email' => 'wiolka95@buziaczek.pl',
            'password' => Hash::make('secret'),
        ]);
        User::create([
            'name' => 'Roger',
            'email' => 'red@october.ru',
            'password' => Hash::make('secret'),
        ]);
    }
}
