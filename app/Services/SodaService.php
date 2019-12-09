<?php

namespace App\Services;

use App\Repositories\Contracts\SodaRepositoryInterface;
use App\Services\Contracts\SodaServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SodaService implements SodaServiceInterface
{
    private $sodaRepository;

    public function __construct(SodaRepositoryInterface $sodaRepository)
    {
        $this->sodaRepository = $sodaRepository;
    }

    public function store(array $attributes)
    {
        $hasInDb = $this->exists($attributes['brand'], $attributes['measureValue'], $attributes['measureUnit']);

        if(!$hasInDb) return $this->sodaRepository->store($attributes);

        throw new HttpException(422,"Já existe um refrigerante com esses dados");
    }

    public function update(array $attributes, string $id)
    {
        try{
          return $this->sodaRepository->update($attributes, $id);
        } catch (\Exception $e) {
            throw new HttpException(422,"Já existe um refrigerante com esses dados");
        }
    }

    public function getAll()
    {
        try{
            return $this->sodaRepository->getAll();
        } catch (\Exception $e) {
            throw new HttpException(400,"Não foi possível buscar os refrigerantes");
        }
    }

    public function get(string $id)
    {
        try{
            return $this->sodaRepository->get($id);
        } catch (\HttpException $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            return $this->sodaRepository->delete($id);
        } catch (\HttpException $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }
    }

    private function exists(string $brand, string $measureValue, string $measureUnit)
    {
       return $this->sodaRepository
            ->checkIfExists($brand, $measureValue, $measureUnit);
    }
}
