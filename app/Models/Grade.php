<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use App\Models\Driver;

class Grade extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'name'
	];
	
	public function cars() 
	{
		return $this->hasMany(Car::class);
	}
	
	public function drivers() 
	{
		return $this->belongsToMany(Driver::class);
	}
}
