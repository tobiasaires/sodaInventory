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
        $sodaAttributes = [
            'brand' => $attributes['brand'],
            'type' => $attributes['type'],
            'unitPrice' => $attributes['unitPrice'],
            'quantity' => $attributes['quantity'],
            'measure' => "${attributes['measureValue']} ${attributes['measureUnit']}",
        ];

        $hasInDb = $this->sodaRepository
            ->checkIfExists($sodaAttributes['brand'], $sodaAttributes['measure']);

        if(!$hasInDb){
            return $this->sodaRepository->store($sodaAttributes);
        }

        throw new HttpException(422,"Já existe um refrigerante com esses dados");
    }
}
