<?php

namespace Tests;

use Faker\Generator as Faker;
use Illuminate\Support\Facades\App;

final class FakerMother
{
    private static ?Faker $faker = null;

    public static function getFaker(): Faker
    {
        if (null === self::$faker) {
            /** @var Faker $faker */
            self::$faker = App::make(Faker::class);

        }
        return self::$faker;
    }


    public static function name(): string
    {
        return self::getFaker()->name();
    }

    public static function productName(): string
    {
        return self::getFaker()->company(); //TODO: do more real this fake data
    }

    public static function quantity(int $min = 1, int $max = 2000): int
    {
        return self::getFaker()->numberBetween($min, $max);
    }

    public static function text(int $max = 200): string
    {
        return self::getFaker()->text($max);
    }

    public static function uuid(): string
    {
        return self::getFaker()->uuid();
    }


    public static function price(int $max = 1000): float
    {
        return self::getFaker()->randomFloat(2, 5, $max);
    }
}
