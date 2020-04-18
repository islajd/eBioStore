<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = ['user_id','product_id'];
    public $incrementing = false;
    protected $table = 'carts';
    protected $fillable = ['user_id','product_id','amount'];

}
