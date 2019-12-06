<?php

namespace App\Repositories;

use App\Repositories\Contracts\SodaRepositoryInterface;
use App\Soda;
use Symfony\Component\HttpKernel\Exception\HttpException;


class SodaRepository implements SodaRepositoryInterface
{
    public function store(array $attributes): array
    {
        try {
            $saveSoda = Soda::create($attributes);
            return ['status' => 'success', 'message' => 'Refrigerante salvo com sucesso'];
        }catch (\MongoConnectionException $exception) {
            throw new HttpException(400, 'Houve um erro, refrigerante não salvo');
        }
    }

    public function checkIfExists(string $brand, string $measure): bool
    {
        return Soda::where('brand', '=', $brand)
            ->where('measure', '=', $measure)
            ->exists();
    }
}
