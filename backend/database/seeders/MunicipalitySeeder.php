<?php

namespace Database\Seeders;

use App\Models\Municipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zone;
use App\Models\Island;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $json = file_get_contents(database_path('data/municipalities.json'));
        $json = file_get_contents('c:\temp\baleartrek\municipalities.json');
        $municipalities = json_decode($json, true);

        foreach ($municipalities['municipis']['municipi'] as $municipality) {
            $zone = Zone::where('Name', $municipality['Zona'])->first(); //Busca en el json Zona
            $island = Island::where('Name', $municipality['Illa'])->first(); //Busca en el json Illa

            Municipality::create([
                'Name' => $municipality['Nom'],
                'zone_id' => $zone?->id, //? para comprobar
                'island_id' => $island?->id
            ]);
        }
    }
}
