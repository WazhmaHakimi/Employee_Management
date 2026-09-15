<?php

namespace App\Enums;

enum EmploymentType: string
{
    case FULL_TIME = 'full_time';
    case PART_TIME = 'part_time';
    case CONTRACT = 'contract';
    case INTERN = 'intern';

    public function label(): string
    {
        return match ($this) {
            self::FULL_TIME => 'Full Time',
            self::PART_TIME => 'Part Time',
            self::CONTRACT => 'Contract',
            self::INTERN => 'Intern',
        };
    }

    public static function options(): array
    {
        return [
            self::FULL_TIME->value => self::FULL_TIME->label(),
            self::PART_TIME->value => self::PART_TIME->label(),
            self::CONTRACT->value => self::CONTRACT->label(),
            self::INTERN->value => self::INTERN->label(),
        ];
    }
}
