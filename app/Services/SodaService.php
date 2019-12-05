<?php

namespace App\Services;

use App\Repositories\Contracts\SodaRepositoryInterface;
use App\Services\Contracts\SodaServiceInterface;

class SodaService implements SodaServiceInterface
{
    private $sodaRepository;

    public function __construct(SodaRepositoryInterface $sodaRepository)
    {
        $this->sodaRepository = $sodaRepository;
    }

    public function store(array $attributes)
    {
        return $this->sodaRepository->store($attributes);
    }
}
