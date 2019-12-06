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
        $sodaAttributes = $this->handleRequestValueToModel($attributes);

        $hasInDb = $this->exists($sodaAttributes['brand'], $sodaAttributes['measure']);

        if(!$hasInDb) return $this->sodaRepository->store($sodaAttributes);

        throw new HttpException(422,"Já existe um refrigerante com esses dados");
    }

    public function update(array $attributes, string $id)
    {
        $sodaAttributes = $this->handleRequestValueToModel($attributes);

        try{
          return $this->sodaRepository->update($sodaAttributes, $id);
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

    private function handleRequestValueToModel(array $attributes): array
    {
        return [
            'brand' => $attributes['brand'],
            'type' => $attributes['type'],
            'unitPrice' => $attributes['unitPrice'],
            'quantity' => $attributes['quantity'],
            'measure' => "${attributes['measureValue']} ${attributes['measureUnit']}",
        ];
    }

    private function exists(string $brand, string $measure)
    {
       return $this->sodaRepository
            ->checkIfExists($brand, $measure);
    }

}
