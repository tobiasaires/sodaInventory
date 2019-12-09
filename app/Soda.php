<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Soda extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'soda';

    protected $fillable = ['brand', 'measureValue', 'measureUnit','type', 'unitPrice', 'quantity'];

}
