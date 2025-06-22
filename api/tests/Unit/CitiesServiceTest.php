<?php

namespace Tests\Unit;

use App\Services\CitiesService;
use App\Services\Providers\BrasilApiProvider;
use PHPUnit\Framework\TestCase;

class CitiesServiceTest extends TestCase
{
    public function test_list_by_uf_returns_cities()
    {
        $mockProvider = $this->createMock(BrasilApiProvider::class);
        $mockProvider->method('getCities')->willReturn([
            ['name' => 'São Paulo', 'ibge_code' => '3550308'],
        ]);

        $mockCache = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['remember'])
            ->getMock();
        $mockCache->method('remember')->willReturn([
            ['name' => 'São Paulo', 'ibge_code' => '3550308'],
        ]);

        $service = new CitiesService($mockProvider, $mockCache);

        $result = $service->listByUf('SP');
        $this->assertEquals('São Paulo', $result[0]['name']);
    }
}