<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function departements()
    {
        return $this->belongsToMany(Departement::class, 'employee_departements', 'employee_id', 'departement_id');
    }
}
