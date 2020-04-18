<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeasurementType extends Model
{
    protected $table = 'measurement_types';

    protected $fillable = ['name'];
}
