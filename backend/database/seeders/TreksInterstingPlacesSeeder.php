<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trek;
use  App\Models\InterestingPlace;

class TreksInterstingPlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // $json = file_get_contents(database_path('data/places.json'));
        $json = file_get_contents('c:\temp\baleartrek\places.json');
        $data = json_decode($json, true);
      

        $treks = Trek::all();  // Tots els 'posts'
        foreach ($treks as $trek) {

            $jsonTrek = collect($data)->firstWhere('regNumber', $trek->regNumber);


            if (!$jsonTrek) continue;
            $contador = 1;

            foreach ($jsonTrek['places_of_interest'] as $poi) {
                $place = InterestingPlace::where('name', $poi['name'])->first();

                if ($place) {
                    $trek->interestingPlaces()->attach($place->id, [
                        'order' => $contador
                    ]);
                }
                $contador++;
            }
        }


      
    }
}
