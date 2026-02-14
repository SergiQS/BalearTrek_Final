<?php

namespace Database\Seeders;

use App\Models\InterestingPlace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlaceType;

class InterestingPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

       // $json = file_get_contents(database_path('data/places.json'));
        $json = file_get_contents('c:\temp\baleartrek\places.json');
        $places = json_decode($json, true);

        foreach ($places as $interestingPlace) {
            foreach ($interestingPlace['places_of_interest'] as $place) {

                PlaceType::firstOrCreate([
                    'name' => $place['type'],

                ]);


                InterestingPlace::updateOrCreate([
                    'name' => $place['name'],
                    'gps' => $place['gpsPos'],
                    'name' => $place['name'],
                    'place_type_id' => PlaceType::where('name', $place['type'])->value('id'),
                ]);
            }
        }
    }
}
