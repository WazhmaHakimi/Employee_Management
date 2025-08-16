<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Country;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $us = Country::where('country_code', 'US')->withCount('employees')->first();
       
        $afg = Country::where('country_code', 'AFG')->withCount('employees')->first();
        return [
            Stat::make('All Employees', Employee::all()->count()),
            Stat::make('US Employees', $us->employees_count),
            Stat::make('AFG Employees', $afg->employees_count),
        ];
    }
}
