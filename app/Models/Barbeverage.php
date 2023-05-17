<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbeverage extends Model
{
    use HasFactory;

    protected $fillable=[
       'iname',
       'quantity',
       'unit',
       'uprice'
    ];
}
