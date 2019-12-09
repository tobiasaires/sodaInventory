<?php


namespace Tests\Feature;

use Tests\TestCase;

class SodaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    protected $baseEndpoint = '/api/soda';

    /** @test */
    public function should_save_soda()
    {
        $attributes = factory('App\Soda')->raw();

        $response = $this->json('POST', $this->baseEndpoint . '/create', $attributes);

        $response->assertStatus(200);
        $response->assertJson(["message" => "Refrigerante salvo com sucesso"]);

    }

    /** @test */
    public function should_get_soda()
    {
        $soda = factory('App\Soda')->create();

        $response = $this->get($this->baseEndpoint . '/' . $soda->_id);
        $response->assertStatus(200);
        $response->assertJson($soda->toArray());
    }

    /** @test */
    public function should_not_create_soda_already_in_DB()
    {
        $soda = factory('App\Soda')->create();

        $response = $this->json('POST', $this->baseEndpoint . '/create', $soda->toArray());

        $response->assertStatus(422);
        $response->assertJson(["message" => "Já existe um refrigerante com esses dados"]);
    }

    /** @test */
    public function should_update_soda()
    {
        $soda = factory('App\Soda')->create();
        $soda = $soda->toArray();
        $soda['brand'] = 'São Geraldo';

        $response = $this->json('PUT', $this->baseEndpoint . '/update/' . $soda['_id'], $soda);
        $response->assertStatus(200);
        $response->assertJson(["message" => "Refrigerante atualizado com sucesso", "data" => $soda]);
    }

    /** @test */
    public function should_not_update_soda_already_in_DB()
    {
        $soda = factory('App\Soda')
            ->create([
                'brand' => "Coca-Cola",
                "measureValue" => '2',
                "measureUnit" => 'L',
                "type" => 'Pet',
                "quantity" => '2',
                "unitPrice"=>'R$ 4.00']);
        $sodaToUpdate = factory('App\Soda')->create();

        $sodaToUpdate = $sodaToUpdate->toArray();
        $sodaToUpdate['brand'] = "Coca-Cola";
        $sodaToUpdate['measureValue'] = '2';
        $sodaToUpdate['measureUnit'] = "L";


        $response = $this->json('PUT', $this->baseEndpoint . '/update/' . $sodaToUpdate['_id'], $sodaToUpdate);
        $response->assertStatus(422);
        $response->assertJson(["message" => "Já existe um refrigerante com esses dados"]);
    }

    /** @test */
    public function should_not_delete_soda()
    {
        $soda = factory('App\Soda')->create();

        $response = $this->json('DELETE', $this->baseEndpoint . '/' .$soda->_id . '/delete');
        $response->assertStatus(200);
        $response->assertJson(["message" => "Refrigerante excluido com sucesso"]);
    }

    /** @test */
    public function should_return_validations_error_on_brand()
    {
        $soda = factory('App\Soda')
            ->raw([
                'brand' => '',
                "measureValue" => '2',
                "measureUnit" => 'L',
                "type" => 'Pet',
                "quantity" => '2',
                "unitPrice"=>'R$ 4.00']);

        $response = $this->json('POST', $this->baseEndpoint . '/create', $soda);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors('brand');
    }
    /** @test */
    public function should_return_validations_error_on_measureValue()
    {
        $soda = factory('App\Soda')
            ->raw([
                'brand' => 'Coca-Cola',
                "measureValue" => '',
                "measureUnit" => 'L',
                "type" => 'Pet',
                "quantity" => '2',
                "unitPrice"=>'R$ 4.00']);

        $response = $this->json('POST', $this->baseEndpoint . '/create', $soda);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors('measureValue');
    }
    /** @test */
    public function should_return_validations_error_on_measureUnit()
    {
        $soda = factory('App\Soda')
            ->raw([
                'brand' => 'Coca-Cola',
                "measureValue" => '2',
                "measureUnit" => '',
                "type" => 'Pet',
                "quantity" => '2',
                "unitPrice"=>'R$ 4.00']);

        $response = $this->json('POST', $this->baseEndpoint . '/create', $soda);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors('measureUnit');
    }
    /** @test */
    public function should_return_validations_error_on_type()
    {
        $soda = factory('App\Soda')
            ->raw([
                'brand' => '',
                "measureValue" => '2',
                "measureUnit" => 'L',
                "type" => '',
                "quantity" => '2',
                "unitPrice"=>'R$ 4.00']);

        $response = $this->json('POST', $this->baseEndpoint . '/create', $soda);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors('type');
    }
    /** @test */
    public function should_return_validations_error_on_quantity()
    {
        $soda = factory('App\Soda')
            ->raw([
                'brand' => 'Coca-Cola',
                "measureValue" => '2',
                "measureUnit" => 'L',
                "type" => 'Pet',
                "quantity" => '',
                "unitPrice"=>'R$ 4.00']);

        $response = $this->json('POST', $this->baseEndpoint . '/create', $soda);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors('quantity');
    }
    /** @test */
    public function should_return_validations_error_on_unitPrice()
    {
        $soda = factory('App\Soda')
            ->raw([
                'brand' => 'Coca-Cola',
                "measureValue" => '2',
                "measureUnit" => 'L',
                "type" => 'Pet',
                "quantity" => '2',
                "unitPrice"=>'']);

        $response = $this->json('POST', $this->baseEndpoint . '/create', $soda);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors('unitPrice');
    }

    /** @test */
    public function should_measureUnit_be_mL_L()
    {
        $soda = factory('App\Soda')
            ->raw([
                'brand' => 'Coca-Cola',
                "measureValue" => '2',
                "measureUnit" => 'oz',
                "type" => 'Pet',
                "quantity" => '2',
                "unitPrice"=>'']);

        $response = $this->json('POST', $this->baseEndpoint . '/create', $soda);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors('measureUnit');
    }

    /** @test */
    public function should_type_be_Pet_Garrafa_Lata()
    {
        $soda = factory('App\Soda')
            ->raw([
                'brand' => 'Coca-Cola',
                "measureValue" => '2',
                "measureUnit" => 'L',
                "type" => 'Ks',
                "quantity" => '2',
                "unitPrice"=>'R$ 4.00']);

        $response = $this->json('POST', $this->baseEndpoint . '/create', $soda);
        $response->assertStatus(400);
        $response->assertJsonValidationErrors('type');
    }

}
