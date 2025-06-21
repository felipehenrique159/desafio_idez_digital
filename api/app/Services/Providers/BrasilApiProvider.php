<?php

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;

class BrasilApiProvider
{
    public function getCities(string $uf): array
    {
        $url = env('URL_BRASIL_API') . "{$uf}";

        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception("Error while querying BrasilAPI");
        }

        return collect($response->json())
            ->map(function($item) {
                return [
                    'name' => $item['nome'],
                    'ibge_code' => $item['codigo_ibge'],
                ];
            })
            ->toArray();
    }
}
