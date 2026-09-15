<?php

namespace App\Models;

use App\Enums\EmploymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'phone_number',
        'email',
        'city_id',
        'state_id',
        'country_id',
        'department_id',
        'position_id',
        'employment_type',
        'zip_code',
        'birth_date',
        'hired_date'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hired_date' => 'date',
        'employement_type' => EmploymentType::class,
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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
