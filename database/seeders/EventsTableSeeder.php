<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = [
            ['Track events','100M'],
            ['Track events','200M'],
            ['Track events','400M'],
            ['Track events','1000M'],
            ['Field events','disk throw'],
            ['Field events','long jump'],
            ['Field events','Javelin throw']
        ];

        foreach ($events as $key => $value){
            $event = Event::create([
                'event_category' => $value[0],
                'event_name' => $value[1]
            ]);
           
        }

           
    }
}
