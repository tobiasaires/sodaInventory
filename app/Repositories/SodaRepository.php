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

    public function checkIfExists(string $brand, string $measureValue, string $measureUnit)
    {
        return Soda::where('brand', '=', $brand)
            ->where('measureValue', '=', $measureValue)
            ->where('measureUnit', '=', $measureUnit)
            ->get()
            ->toArray();
    }

    public function update(array $attributes, string $id)
    {
        $soda =  Soda::find($id);

        $sodaInDB = $this->checkIfExists($attributes['brand'], $attributes['measureValue'], $attributes['measureUnit']);

        if( isset($sodaInDB[0]['_id']) && $id != $sodaInDB[0]['_id']) throw  new \Exception();

        try {
            $soda->brand = $attributes['brand'];
            $soda->type = $attributes['type'];
            $soda->unitPrice = $attributes['unitPrice'];
            $soda->quantity = $attributes['quantity'];
            $soda->measureValue = $attributes['measureValue'];
            $soda->measureUnit = $attributes['measureUnit'];
            $soda->save();

            return ['status' => 'success', 'message' => 'Refrigerante atualizado com sucesso', 'data' => $soda];
        } catch (\Exception $exception) {
            throw new HttpException(400, 'Houve um erro, refrigerante não atualizado');
        }

    }

    public function getAll()
    {
        try {
            return Soda::all();
        } catch (\Exception $exception) {
            throw new HttpException(400, 'Houve um erro');
        }
    }

    public function get(string $id)
    {
        try {
            $soda = Soda::find($id);
        } catch (\Exception $exception) {
            throw new HttpException(400, 'Houve um erro');
        }

        if(!$soda) {
            throw new HttpException(404, 'Refrigerante não econtrado');
        }

        return $soda;
    }

    public function delete($json)
    {
        try {
            Soda::destroy($json);
        } catch (\Exception $exception) {
            throw new HttpException(400, 'Houve um erro ao deletar refrigerante');
        }

        return ['status' => 'success', 'message' => 'Refrigerante excluido com sucesso'];
    }
}
