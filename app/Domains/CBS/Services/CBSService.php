<?php

namespace App\Domains\CBS\Services;


use App\Domains\Classes\RatePeriod;
use Illuminate\Support\Facades\Http;

class CBSService
{
    private const CBS_API_URL = 'https://opendata.cbs.nl/ODataApi/odata/84672NED/TypedDataSet';

    /**
     * @return RatePeriod[]
     */
    public function getRates(): array
    {
        return array_map(function ($item) {
            return new RatePeriod(
                $item['Perioden'],
                $item['VastLeveringstarief_2'],
                $item['VariabelLeveringstarief_3'],
            );
        }, Http::get(self::CBS_API_URL)->json('value'));
    }

    public function getLatestRate(): RatePeriod
    {
        $rates = $this->getRates();
        return end($rates);
    }
}
