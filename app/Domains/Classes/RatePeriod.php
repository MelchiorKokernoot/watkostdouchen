<?php

namespace App\Domains\Classes;

class RatePeriod
{
    public function __construct(
        public string $period,
        public float  $rateVariable,
    )
    {
    }
}
