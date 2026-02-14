<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meeting;
use App\Models\User;

class UserMeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //crear el meeting recorrer el meeting coger todos los que no sea admin despue random 
        //coger mínimo 25 quitar los users el guía si esta después atach

        $meetings = Meeting::all();

        foreach ($meetings as $meeting) {
            $count = rand(21, 30);
            $users = User::where('role_id', '!=', '1')->inRandomOrder()->limit($count)->get();
            
            $filteredUsers = $users->filter(function ($user) use ($meeting) {  //Filtrar la colección para excluir al guía del meeting actual
                // El  user_id en la tabla meetings representa al guía

                return $user->id != $meeting->user_id;
            });


            //$selectedUsers = $users->pluck('id');

            $meeting->users()->attach($filteredUsers);
        }
    }
}
