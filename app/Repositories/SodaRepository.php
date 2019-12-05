<?php

namespace App\Repositories;

use App\Repositories\Contracts\SodaRepositoryInterface;
use App\Soda;

class SodaRepository implements SodaRepositoryInterface
{
    public function store(array $attributes)
    {
        return Soda::create($attributes);
    }
}
