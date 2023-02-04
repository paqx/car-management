<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use App\Models\Grade;
use App\Models\Reservation;

class Driver extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'car_id',
		'name'
	];
		
	public function car() 
	{
		return $this->hasOne(Car::class);
	}
	
	public function grades() 
	{
		return $this->belongsToMany(Grade::class);
	}
	
	public function reservations() 
	{
		return $this->hasMany(Reservation::class);
	}
}
