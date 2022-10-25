<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EmployeeResource;
use App\Models\Employee;

class EmployeeApiController extends Controller
{
    public function index()
    {
        return EmployeeResource::collection(Employee::paginate());
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }
}