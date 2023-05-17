<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foodresto extends Model
{
    use HasFactory;

    protected $fillable=[
        'foodname',
        'foodquantity',
        'foodunit',
        'fooduprice',

    ];
}
