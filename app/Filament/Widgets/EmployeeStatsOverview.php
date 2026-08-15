<?php

namespace App\Filament\Widgets;

use App\Models\Country;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $afg = Country::where('country_code', 'AFG')->withCount('employees')->first();

        $us = Country::where('country_code', 'US')->withCount('employees')->first();

        return [
            Stat::make('All Employees', Employee::all()->count()),
            Stat::make('US Employees', $us ? $us->employees_count : 0),
            Stat::make('AFG Employees', $afg ? $afg->employees_count : 0),
        ];
    }
}
