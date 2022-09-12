<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'departement_id',
        'zip_code',
        'birth_date',
        'date_hired'
    ];

    public function counrty()
    {
        return $this->belongTo(Country::class);
    }

    public function state()
    {
        return $this->belongTo(State::class);
    }

    public function city()
    {
        return $this->belongTo(City::class);
    }

    public function departement()
    {
        return $this->belongTo(Departement::class);
    }
}
