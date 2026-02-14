<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;


class UserJsonseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        //Carga de guias
        // $json = file_get_contents(database_path('data/users.json'));
        $json = file_get_contents('c:\temp\baleartrek\users.json');
        $users = json_decode($json, true);

        foreach ($users['usuaris']['usuari'] as $user) {


            User::create([
                'name' => $user['nom'],
                'lastname' => $user['llinatges'],
                'dni' => $user['dni'],
                'phone' => $user['telefon'],
                'email' => $user['email'],
                'password' => $user['password'],
                'role_id' => Role::where('name', 'guia')->value('id')
            ]);
        }
    }
}
