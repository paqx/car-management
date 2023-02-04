<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use App\Models\Driver;

class Reservation extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'car_id',
		'driver_id',
		'start',
		'end'
	];

	public function car() 
	{
		return $this->belongsTo(Car::class);
	}
	
	public function driver() 
	{
		return $this->belongsTo(Driver::class);
	}
}
