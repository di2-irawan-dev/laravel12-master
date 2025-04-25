<?php

namespace App\Enums;

enum NoYes: string
{
    case No = 'No';
    case Yes = 'Yes';

    public function name(): string
    {
        return match ($this) {
            self::No => 'No',
            self::Yes => 'Yes',
        };
    }

    public static function options(): array
    {
        return [
            [
                'id' => self::No->value,
                'name' => self::No->name(),
            ],
            [
                'id' => self::Yes->value,
                'name' => self::Yes->name(),
            ],
        ];
    }
}
