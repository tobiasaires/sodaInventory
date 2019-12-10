<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Soda::class, function (Faker $faker) {
    return [
        "brand"=> \Faker\Provider\Base::randomElement($brands = ["Coca-Cola", "Pepsi", "Fanta", "Guarana"]),
        "measureUnit" => \Faker\Provider\Base::randomElement($measureUnit = ["L", "mL"]),
        "measureValue" => "{$faker->randomNumber()}",
        "type" => \Faker\Provider\Base::randomElement($types = ["Pet", "Garrafa", "Lata"]),
        "quantity" => 2,
        "unitPrice" => "R$ 5.00"
    ];
});
