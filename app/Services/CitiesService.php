<?php

namespace App\Services;

use App\Services\Providers\BrasilApiProvider;
use App\Services\Providers\IbgeApiProvider;

class CitiesService
{
    protected $provider;

    public function __construct()
    {
        $this->setProvider();
    }

    public function listByUf(string $uf): array
    {
        return $this->provider->getCities($uf);
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
