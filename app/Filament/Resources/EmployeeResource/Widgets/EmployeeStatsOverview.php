<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use DateTime;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EmployeeStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $dt = new DateTime();
        $dt = date('Y-m-d', strtotime('-1 years'));
        $thisYearEmployees = DB::table('employees')->select('*')->whereDate('date_hired', '>', $dt)->get();
        return [
            Card::make('All Employees', Employee::all()->count()),
            Card::make('Employees hired this year', $thisYearEmployees->count()),
        ];
    }


}
