<?php

namespace App\Services\Wallet;

use App\Models\Wallet;
use App\Services\BaseServiceInterface;
use App\Models\User;
use App\Services\Utilities\PostHttpRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class TransferService implements BaseServiceInterface
{
    protected $data, $user;

    public function __construct($data,$user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    public function run()
    {

        if($this->data['islocal']){
            $res = $this->SendLocal($this->data);
            if($res->statusCode == 200){
              return $res->data;
            } else if($res->statusCode == 400){
                throw new Exception($res->message);
            }else{
             throw new Exception("Failed with unnknow error");
            }
        }else{
            $res = $this->SendToExternal($this->data);
            if($res->statusCode == 200){
                return $res->data;
              } else if($res->statusCode == 400){
                  throw new Exception($res->message);
              }else{
               throw new Exception("Failed with unnknow error");
              }
        }
       
       
    }



    private function SendToExternal($data)
    {
      
        $url = env('BASE_URL') . 'accounts/transfer';

        $body=[
            "debitAccountId"=>  $this-> WalletNumber($data['sender_wallet_id']),
            "beneficiaryAccountNumber"=> $data['account_number'],
            "beneficiaryBankCode"=> $data['bank_code'],
            "amount"=>  $data['amount'],
            "paymentReference"=> $this->RandomString(12),
            "narration"=>$data['narration'],
        ];
            $res = new PostHttpRequest($url,$body);
            $res =  $res->run();
            return $res;
    }


    private function SendLocal($data)
    {
        $url = env('BASE_URL') . 'accounts/transfer';

        $body=[
            "debitAccountId"=>  $this-> WalletNumber($data['sender_wallet_id']),
            "creditAccountId"=> $this-> WalletNumber($data['reciever_sender_id']),
            "amount"=>  $data['amount'],
            "paymentReference"=> $this->RandomString(16),
            "narration"=>$data['narration'],
        ];

            $res = new PostHttpRequest($url,$body);
            $res =  $res->run();
            return $res;
    }
    
    private function WalletNumber($id){
        $wallet = Wallet::where('id', $id)->firstOrFail();
        return  $wallet->merchant_account_id;
    }
   
    function RandomString($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
     
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
     
        return $randomString;
    }

}
