<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SchoolDataSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = [
            'Main Building' => '12 Riverside Avenue',
            'Science Center' => '24 Knowledge Road',
            'Arts Hall' => '8 Campus Lane',
        ];

        foreach ($buildings as $name => $address) {
            $building = Building::updateOrCreate(['name' => $name], ['address' => $address]);

            foreach (['Ground', '1', '2'] as $floorNumber) {
                $floor = Floor::updateOrCreate(
                    ['building_id' => $building->id, 'floor_number' => $floorNumber],
                    []
                );

                foreach (['101', '102', '103'] as $roomNumber) {
                    Room::updateOrCreate(
                        ['floor_id' => $floor->id, 'room_number' => $floorNumber === 'Ground' ? 'G'.$roomNumber : $floorNumber.$roomNumber],
                        []
                    );
                }
            }
        }

        foreach ([
            ['name' => 'Sokha Chan', 'age' => 34, 'subject' => 'Mathematics'],
            ['name' => 'Dara Kim', 'age' => 41, 'subject' => 'Science'],
            ['name' => 'Malis Vann', 'age' => 29, 'subject' => 'English'],
            ['name' => 'Rithy Chea', 'age' => 37, 'subject' => 'History'],
            ['name' => 'Sreyneang Lim', 'age' => 31, 'subject' => 'Computer Science'],
        ] as $teacher) {
            Teacher::updateOrCreate(['name' => $teacher['name']], $teacher);
        }
    }
}
