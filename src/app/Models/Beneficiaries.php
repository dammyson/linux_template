<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiaries extends Model
{
   
    use HasFactory, UuidTrait ;
    protected $fillable = [
        'id', 
        'user_id',
        'first_name',
        'last_name',
        'wallet_id',
        'account_number',
        'bank_code'
    ];
}
