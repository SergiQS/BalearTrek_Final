<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zone;
 


class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //$json=file_get_contents(database_path('data/zones.json'));
        $json=file_get_contents('c:\temp\baleartrek\zones.json');
        $zones=json_decode($json,true);

        foreach($zones['zones']['zona']as $zona) {
            Zone::create([
                'Name'=> $zona['Nom']
            ]);
        }


    }
}
