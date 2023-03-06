<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory, UuidTrait;

    protected $fillable = [
        'id', 
        'user_id',
        'qr_code',
        'merchant_account_id',
        'account_number', 
        'account_name',
        'bank_code',
        'currency', 
        'type', 
        'bank', 
        'status'
        
    ];
}
