<div>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="flex-col">
                <div class="stats shadow">
                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 class="inline-block w-8 h-8 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Periode</div>
                        <div class="stat-value text-xl">{{$latestRate->period}}</div>
                    </div>

                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 class="inline-block w-8 h-8 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Variabel</div>
                        <div class="stat-value text-xl">€ {{$latestRate->rateVariable}}</div>
                    </div>
                </div>
                <div class="pt-12">
                    <div class="flex-col">
                        <h1 class="text-5xl font-bold">Hoeveel kost douchen nu?</h1>
                    </div>

                    <div class="flex-col py-6 ">
                        <div class="flex justify-around">
                            <label>
                                Variabel
                                <input type="radio" wire:model="mode" value="variable" name="radio-1" class="radio"/>
                            </label>
                            <label>
                                Vast
                                <input type="radio" wire:model="mode" value="fixed" class="radio"/>
                            </label>
                        </div>

                        @if($mode === 'fixed')
                            <div class="flex justify-center">
                                <div class="form-control w-full max-w-xs">
                                    <label class="label">
                                        <span class="label-text">Wat is uw tarief?</span>
                                    </label>
                                    <input
                                        wire:model.debounce.500ms="customRate"
                                        type="number"
                                        step="0.01"
                                        placeholder="Tarief"
                                        class="input input-bordered w-full"/>
                                    <label class="label">
                                        <span class="label-text-alt">Als u geen tarief invult gebruiken wij het gemiddelde voor de afgelopen maand.</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <p class="py-6">
                        Druk op start wanneer u begint met douchen en stop wanneer u klaar bent.
                    </p>

                    @if(!$totalPrice)
                        @if(!$timerRunning)
                            <button class="btn btn-primary" wire:click="startTimer">Start</button>
                        @else
                            <h2 class="text-5xl font-bold py-2" wire:poll.1s>
                                {{$this->getTimeDiffForHumans()}}
                            </h2>
                            <button class="btn btn-primary" wire:click="stopTimer">Stop</button>
                        @endif

                    @else
                        <h3 class="text-xl font-semibold py-2">
                            U heeft {{$this->getTimeDiffForHumans()}} gedoucht. Dat kost u ongeveer:
                        </h3>
                        <h2 class="text-5xl font-bold py-2">
                            €{{$totalPrice}}
                        </h2>
                    @endif
                </div>


                <p class="py-24">Houdt er ten alle tijden rekening mee dat deze gegevens een indicatie zijn.</p>
            </div>
        </div>
    </div>
</div>
