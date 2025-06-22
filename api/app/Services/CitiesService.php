<?php

namespace App\Services;

class CitiesService
{
    protected $provider;
    protected $cache;

    public function __construct($provider, $cache)
    {
        $this->provider = $provider;
        $this->cache = $cache;
    }

    public function listByUf(string $uf): array
    {
        $cacheKey = "cities_{$uf}_" . env('CITIES_PROVIDER');

        return $this->cache->remember($cacheKey, 60 * 60, function () use ($uf) {
            return $this->provider->getCities($uf);
        });
    }
}
