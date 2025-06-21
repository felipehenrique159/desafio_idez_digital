<?php

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;

class IbgeApiProvider
{
    public function getCities(string $uf): array
    {
        $url = env('URL_IBGE_API') . $uf . '/municipios';

        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception("Error while querying IBGE API");
        }

        return collect($response->json())
            ->map(function($item) {
                return [
                    'name' => $item['nome'],
                    'ibge_code' => $item['id'],
                ];
            })
            ->toArray();
    }
}
