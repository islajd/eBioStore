<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Details extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'order_details';
    protected $fillable = ['order_id','product_id','price','quantity'];

}
