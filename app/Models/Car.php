<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Driver;
use App\Models\Grade;
use App\Models\Reservation;

class Car extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'grade_id',
		'make',
		'model'
	];
	
	public function grade() 
	{
		return $this->belongsTo(Grade::class);
	}
	
	public function driver() 
	{
		return $this->belongsTo(Driver::class);
	}
	
	public function reservations() 
	{
		return $this->hasMany(Reservation::class);
	}
}
