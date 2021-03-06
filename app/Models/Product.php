<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    Protected $table = 'product';
    
    Protected $fillable = ['name', 'type', 'price', 'expired_at'];
}
