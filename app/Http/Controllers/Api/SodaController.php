<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SodaServiceInterface;
use Illuminate\Http\Request;

class SodaController extends Controller
{
    private $sodaService;

    public function __construct(SodaServiceInterface $sodaService)
    {
        $this->sodaService = $sodaService;
    }

    public function create(Request $request)
    {
        $soda = $this->sodaService->store($request->all());

        return response()->json($soda);
    }

}
