<?php

namespace App\Http\Controllers;

use App\Services\CitiesService;
use App\Validators\UfValidator;
use Illuminate\Validation\ValidationException;

class CitiesController extends Controller
{
    protected $citiesService;

    public function __construct(CitiesService $citiesService)
    {
        $this->citiesService = $citiesService;
    }

    public function index(string $uf)
    {
        try {

            UfValidator::validate($uf);

            $search = request('search');
            $perPage = (int) request('per_page', 10);
            $page = (int) request('page', 1);

            $cities = $this->citiesService->listByUf($uf);

            if ($search) {
                $cities = array_filter($cities, function ($item) use ($search) {
                    return stripos($item['name'], $search) !== false;
                });
            }

            $total = count($cities);
            $cities = array_values($cities);
            $results = array_slice($cities, ($page - 1) * $perPage, $perPage);

            return response()->json([
                'data' => $results,
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => ceil($total / $perPage)
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error in validation',
                'details' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error fetching cities',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
