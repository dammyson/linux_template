<?php

namespace App\Http\Requests\Wallet;

use App\Http\Requests\Request;

class TransferRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_wallet_id' => 'required|string',
            'amount' => 'required|numeric',
            'pin'=> 'required|string|size:4',
            'narration'=> 'required|string',
            'islocal'=> 'required|boolean',
            'reciever_sender_id' => 'required_if:islocal,==,true|nullable|string',
            'account_number' => 'required_if:islocal,==,false|nullable|string',
            'bank_code' => 'required_if:islocal,==,false|nullable|string',
        ];
    }
}