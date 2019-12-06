<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditSodaRequest;
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
            return $this->sodaService->store($request->all());
        } catch (\HttpException $e) {
            return ['message' => $e->getMessage(), 'status' => $e->getCode()];
        }
    }

    public function update(SodaRequest $request, string $id)
    {
        try {
            return $this->sodaService->update($request->all(), $id);
        } catch (\HttpException $e) {
            return ['message' => $e->getMessage(), 'status' => $e->getCode()];
        }
    }

    public function getAll()
    {
        try {
            return $this->sodaService->getAll();
        } catch (\HttpException $e) {
            return ['message' => $e->getMessage(), 'status' => $e->getCode()];
        }
    }

    public function get(string $id)
    {
        try {
            return $this->sodaService->get($id);
        } catch (\HttpException $e) {
            return ['message' => $e->getMessage(), 'status' => $e->getCode()];
        }
    }

}
