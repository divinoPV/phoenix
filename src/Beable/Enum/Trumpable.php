<?php

namespace App\Beable\Enum;

trait Trumpable
{
    public static function random(): static
    {
        return static::cases()[array_rand(static::cases())];
    }

    public function label(): string
    {
        return 'enum.'.$this->value.'.label';
    }

    public function slug(): string
    {
        return str_replace(['.', '_'], ['-', '-'], $this->value);
    }
}
