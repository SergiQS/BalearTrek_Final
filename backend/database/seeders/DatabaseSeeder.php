<?php

namespace Database\Seeders;

use App\Models\InterestingPlace;
use App\Models\Municipality;
use App\Models\Place_Types;
use App\Models\Role;
use App\Models\Trek;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(ZoneSeeder::class);
        $this->call(IslandSeeder::class);
        $this->call(MunicipalitySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserJsonSeeder::class);
        $this->call(TrekSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(PlaceTypeSeeder::class);
        $this->call(InterestingPlaceSeeder::class);
        $this->call(TreksInterstingPlacesSeeder::class);
        $this->call(UserMeetingSeeder::class);

    }
}
