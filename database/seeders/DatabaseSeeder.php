<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Grade;
use App\Models\Reservation;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
	private $grades = [
		'truck',
		'sports',
		'luxury',
		'van',
		'suv',
		'pickup'
	];

	private $makes = [
		'Honda',
		'Volkswagen',
		'Alfa Romeo',
		'BMW',
		'Buick',
		'Cadillac',
		'Chevrolet',
		'Lada'
	];
	
	private $models = [
		'Accent',
		'Dakota',
		'Defender',
		'2115 Samara',
		'Eagle',
		'Tacoma',
		'Ranger',
		'Evora',
		'Flex',
		'Viscount',
		'Montero',
		'Golf'
	];
	
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		foreach ($this->grades as $grade) {
			Grade::factory()->create([
				'name' => $grade
			]);
		}
		
		Driver::factory()->count(10)->create();
		
		$drivers = Driver::all();
		
		foreach ($drivers as $driver) {
			Car::factory()->create([
				'grade_id' => Grade::all()->random()->id,
				'driver_id' => $driver->id,
				'make' => $this->makes[array_rand($this->makes)],
				'model' => $this->models[array_rand($this->models)]
			]);
		}
		
		$cars = Car::all();
		$grades = Grade::all();
		
		Driver::all()->each(function ($driver) use ($grades) {
			$driver->grades()->attach($grades->random(rand(1, 3))->pluck('id')->toArray());
		});
		
		for ($i = 0; $i < 50; $i++) {
			$datetime = Carbon::today()->addDays(rand(1, 365))
				->addHours(rand(1, 24));

			Reservation::factory()->create([
				'car_id' => Car::all()->random()->id,
				'driver_id' => Driver::all()->random()->id,
				'start' => $datetime->toDateTimeString(),
				'end' => $datetime->addHours(rand(1, 8))->toDateTimeString()
			]);
		}
    }
}
