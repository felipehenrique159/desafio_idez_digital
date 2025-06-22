<?php

namespace Tests\Feature;

use Tests\TestCase;

class CitiesControllerTest extends TestCase
{
    public function test_index_returns_200()
    {
        $response = $this->get('/api/cities/SP');
        $response->assertStatus(200);
    }

    public function test_index_invalid_uf_returns_422()
    {
        $response = $this->get('/api/cities/INVALID');
        $response->assertStatus(422);
    }
}