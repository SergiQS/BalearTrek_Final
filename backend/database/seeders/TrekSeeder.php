<?php

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\Municipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\InterestingPlace;
use App\Models\PlaceType;
use Illuminate\Database\Seeder;
use App\Models\Trek;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Comment;


class TrekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        //$json = file_get_contents(database_path('data/treks.json'));
        $json = file_get_contents('c:\temp\baleartrek\treks.json');
        $treks = json_decode($json, true);



        foreach ($treks as $trek) {
            Trek::create([
                'regNumber' => $trek['regNumber'],
                'name' => $trek['name'],
                'rating'=> 0,
                'municipality_id' =>  Municipality::where('Name', $trek['municipality'])->value('id'),
                //  'status' => $trek['status'],
            ]);


            foreach ($trek['meetings'] as $meeting) {
               // $fecha = Carbon::parse($meeting['day'])->subMonth();
               // $fechaEnd = $fecha->subWeek();
                $guiaId = User::where('dni', $meeting['DNI'])->value('id');
                if (!$guiaId) {
                    $guiaId = User::where('name', 'admin')->value('id');
                }


                $createdMeeting = Meeting::create([
                    'trek_id' => Trek::where('regNumber', $trek['regNumber'])->value('id'),
                    'dateIni' => Carbon::parse($meeting['day'])->subMonth()->format('Y-m-d'),
                    'dateEnd' => Carbon::parse($meeting['day'])->subWeek()->format('Y-m-d'),
                    'totalScore'=> 0,
                    'countScore'=> 0,
                    'rating'=> 0,
                    'user_id' => $guiaId,
                    'day' => $meeting['day'],
                    'hour' => $meeting['time']
                ]);

              

                foreach ($meeting['comments'] as $comment) {
                    $visId = User::where('dni', $comment['DNI'])->value('id');
                    Comment::create([
                        'comment' => $comment['comment'],
                        'score' => $comment['score'],
                        //'status'=> '',
                        'user_id' => $visId,
                        'meeting_id' => $createdMeeting->id //Meeting::where('trek_id',Trek::where('regNumber', $trek['regNumber'])->value('id'))->value('id')

                    ]);
                }
            }
        }

    }
}
