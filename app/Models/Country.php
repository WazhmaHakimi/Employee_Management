<?php

namespace App\Models;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'country_code', 
        'name'
    ];

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
