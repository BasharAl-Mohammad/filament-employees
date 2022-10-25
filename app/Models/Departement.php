<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    use HasFactory;

    protected $fillable =['name'];
    

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_departements', 'departement_id', 'employee_id');
    }
}
