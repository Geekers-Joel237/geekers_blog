<?php

namespace App\Database\Factories;
use Faker\Factory;
use Faker\Generator;

trait BaseFactory
{
    public function faker(): Generator
    {
        return Factory::create();
    }
}