<?php

namespace Database\Seeders;

use App\Models\Island;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IslandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       // $json=file_get_contents(database_path('data/islands.json'));
        $json=file_get_contents('c:\temp\baleartrek\islands.json');
        $islands=json_decode($json,true);

        foreach($islands['illes']['illa']as $illa) {
            Island::create([
                'Name'=> $illa['Nom']
            ]);
        }

    }
}
