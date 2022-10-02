<?php

namespace App\Http\Livewire;

use App\Domains\CBS\Services\CBSService;
use App\Domains\Classes\RatePeriod;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public string $timeStart = '';
    public string $timeEnd = '';
    public bool $timerRunning = false;
    public string $mode = 'fixed';
    public $customRate;
    public float $totalPrice;

    private const CUBIC_METER_USED_PER_MINUTE = 0.04;

    protected $rules = [
        'mode' => 'required|in:fixed,variable',
        'customRate' => 'numeric|min:0',
    ];

    public function getLatestRate(): RatePeriod
    {
        $service = app(CBSService::class);
        return $service->getLatestRate();
    }

    public function startTimer()
    {
        if (!$this->timerRunning) {
            $this->timeStart = CarbonImmutable::now()->toDateTimeString();
            $this->timerRunning = true;
        }
    }

    public function stopTimer()
    {
        $this->timerRunning = false;
        $this->calculatePriceWithLatestRate();
    }

    public function calculatePriceWithLatestRate()
    {
        if ($this->mode === 'fixed' && isset($this->customRate)) {
            $rate = $this->customRate;
        } else {
            $rate = $this->getLatestRate()->rateVariable;
        }

        $now = CarbonImmutable::now();
        $start = CarbonImmutable::parse($this->timeStart);
        $ratePerminute = $rate * self::CUBIC_METER_USED_PER_MINUTE;
        $ratePerSecond = $ratePerminute / 60;

        $priceOfShower = $now->diffInSeconds($start) * $ratePerSecond;
        $this->totalPrice = $priceOfShower;
    }

    public function getTimeDiffForHumans(): string
    {
        Carbon::setLocale('nl');
        $now = CarbonImmutable::now();
        $start = CarbonImmutable::parse($this->timeStart);
        $options = [
            'join' => ', ',
            'parts' => 2,
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
        ];

        return $now->diffForHumans($start, $options);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.index')->with([
            'latestRate' => $this->getLatestRate(),
        ]);
    }
}
