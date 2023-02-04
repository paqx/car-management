<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Reservation;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function cars(Request $request) 
	{
		$response = [
			'response' => null, 
			'success' => false
		];
		
		$rules = [
			'driver_id' => 'required|integer|exists:drivers,id',
			'grade' => 'nullable|string|max:50|exists:grades,name',
			'start_datetime' => 'required|date',
			'end_datetime' => 'required|date',
			'make' => 'nullable|string|max:50|exists:cars,make',
			'model' => 'nullable|string|max:50|exists:cars,model',
		];
		
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			$response['response'] = $validator->messages();
			
			return response()->json($response);
		}
		
		$driver = Driver::find($request->get('driver_id'));
		$grade = $request->get('grade');
		
		if (isset($grade) && !$driver->grades->contains('name', $grade)) {
			$response['response'] = 'The driver is not allowed to reserve cars with the selected grade.';
			
			return response()->json($response);
		}
		
		$start_datetime = Carbon::parse($request->get('start_datetime'));
		$end_datetime = Carbon::parse($request->get('end_datetime'));
		$make = $request->get('make');
		$model = $request->get('model');

		$reservations = Reservation::query()
			->select('reservations.id', 'reservations.start', 'reservations.end', 'cars.make', 'cars.model')
			->leftJoin('cars', 'reservations.car_id', '=', 'cars.id')
			->when($make, function ($query) use ($make) {
				$query->where('make', $make);
			})->when($model, function ($query) use ($model) {
				$query->where('model', $model);
			})->where([
				['end', '>=', $start_datetime->toDateTimeString()],
				['start', '<=', $end_datetime->toDateTimeString()]
			])->orderBy('start', 'ASC')
			->get();
			
		if ($reservations->isEmpty()) {
			$response['response'] = 'There are no cars available within the selected timeframe.';
			
			return response()->json($response);
		} else {
			$slots = $this->getSlots($start_datetime, $end_datetime, $reservations);
			
			$response = [
				'response' => ['slots' => $slots], 
				'success' => true
			];
			
			return response()->json($response);
		}
	}
	
	private function getSlots(Carbon $start_datetime, Carbon $end_datetime, Collection $reservations): array
	{
		$slots = [];

		foreach ($reservations as $reservation) {
			// First reservation
			if ($reservation->id == $reservations->first()->id) {
				if ($start_datetime < $reservation->start) {
					array_push($slots, [
						$start_datetime, 
						$reservation->start
					]);
				}
				if ($end_datetime > $reservation->end && $reservations->count() == 1) {
					array_push($slots, [
						$reservation->end, 
						$end_datetime
					]);
				}
			// Last reservation
			} elseif ($reservation->id == $reservations->last()->id) {
				array_push($slots, [
					$previous->end, 
					$reservation->start
				]);
				
				if ($end_datetime > $reservation->end) {
					array_push($slots, [
						$reservation->end, 
						$end_datetime
					]);
				}
			// Intermediary reservations
			} else {
				array_push($slots, [
					$previous->end, 
					$reservation->start
				]);
			}
			// Keep the current reservation to use it in the next iteration
			$previous = $reservation;
		}
		
		return $slots;
	}
}