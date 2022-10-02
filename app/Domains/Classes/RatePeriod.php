<?php

namespace App\Domains\Classes;

class RatePeriod
{
    public function __construct(
        public readonly string $period,
        public readonly float  $rateFixed,
        public readonly float  $rateVariable,
    )
    {
    }
}