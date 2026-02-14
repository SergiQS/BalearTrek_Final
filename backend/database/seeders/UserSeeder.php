<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSeeder extends Seeder
{   
    use HasFactory;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Usuari d'inici
        $user = new User();
        $user->name = "admin";
        $user->lastname="administrator";
        $user->dni="000000000";
        $user->phone="0";
        $user->email = "admin@baleartrek.com";
        $user->password = Hash::make('12345678');
        $user->role_id = Role::where('name', 'admin')->value('id');
        $user->save();
        

         User::factory(100)->create([
            'role_id' => Role::where('name','visitant')->value('id'),
        ]);



      
    }
}
