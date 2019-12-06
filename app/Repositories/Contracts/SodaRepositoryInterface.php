<?php

namespace App\Repositories\Contracts;

interface SodaRepositoryInterface
{
    public function store(array $attributes): array ;

    public function checkIfExists(string $brand, string $measure): bool ;
}
