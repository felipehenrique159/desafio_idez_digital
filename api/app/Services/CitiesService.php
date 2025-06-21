<?php

namespace App\Services;

use App\Services\Providers\BrasilApiProvider;
use App\Services\Providers\IbgeApiProvider;
use Illuminate\Support\Facades\Cache;
class CitiesService
{
    protected $provider;

    public function __construct()
    {
        $this->setProvider();
    }

    public function listByUf(string $uf): array
    {
        $cacheKey = "cities_{$uf}_" . env('CITIES_PROVIDER');

        return Cache::remember($cacheKey, 60 * 60, function () use ($uf) {
            return $this->provider->getCities($uf);
        });
    }

    private function setProvider()
    {
        $provider = env('CITIES_PROVIDER', 'brasilapi');

        if ($provider === 'brasilapi') {
            $this->provider = new BrasilApiProvider();
        } elseif ($provider === 'ibgeapi') {
            $this->provider = new IbgeApiProvider();
        } else {
            throw new \Exception("Provider not supported: {$provider}");
        }
    }
}
