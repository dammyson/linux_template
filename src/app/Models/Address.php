<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory, UuidTrait;

    protected $fillable = [
        'id', 
        'user_id',
        'account_number', 
        'currency', 
        'type', 
        'bank', 
        
    ];

}
