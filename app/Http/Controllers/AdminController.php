<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function index() 
	{
		$drivers = Driver::paginate(10);
		
		return view('index', compact('drivers'));
	}
	
	public function driver($id) 
	{
		$driver = Driver::find($id);
		$grades = $driver->grades;

		$cars = Car::where(function ($query) use ($grades) {
			foreach ($grades as $grade) {
				$query->orWhere('grade_id', $grade->id);
			}
		})->paginate(10);

		return view('driver', compact([
			'driver',
			'cars'
		]));
	}
	
	public function car($id) 
	{
		$car = Car::find($id);
		$reservations = Reservation::where('car_id', $car->id)->orderBy('start', 'ASC')->paginate(10);

		return view('car', compact([
			'car',
			'reservations'
		]));
	}
}
