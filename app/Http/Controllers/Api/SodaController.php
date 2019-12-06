<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SodaServiceInterface;
use App\Http\Requests\SodaRequest;

class SodaController extends Controller
{
    private $sodaService;

    public function __construct(SodaServiceInterface $sodaService)
    {
        $this->sodaService = $sodaService;
    }

    public function create(SodaRequest $request)
    {
        try {
            $soda = $this->sodaService->store($request->all());

            return $soda;
        } catch (\HttpException $e) {
            return ['message' => $e->getMessage(), 'status' => $e->getCode()];
        }
    }

}
