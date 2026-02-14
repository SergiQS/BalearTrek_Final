<?php

namespace Database\Seeders;

use App\Models\Municipality;
use App\Models\PlaceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        //$json = file_get_contents(database_path('data/places.json'));
        $json = file_get_contents('c:\temp\baleartrek\places.json');
        $places = json_decode($json, true);
        foreach ($places as $placeType) {
            foreach ($placeType['places_of_interest'] as $place) {
                PlaceType::updateOrCreate([
                    'name' => $place['type'],
                    'name' => $place['type'],
                ]);
            }
        }
    }
}
