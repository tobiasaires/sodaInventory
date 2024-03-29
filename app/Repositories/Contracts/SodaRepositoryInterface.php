<?php

namespace App\Repositories\Contracts;

interface SodaRepositoryInterface
{
    public function store(array $attributes): array ;

    public function checkIfExists(string $brand, string $measureValue, string $measureUnit);

    public function update(array $attributes, string $id);

    public function getAll();

    public function get(string $id);

    public function delete($id);

}
