<?php

namespace App\Services\Contracts;

interface SodaServiceInterface
{
    public function store(array $attributes);

    public function update(array $attributes, string $id);

    public function getAll();

    public function get(string $id);

}
