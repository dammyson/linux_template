<?php

namespace App\Services\Transaction;

use App\Models\Wallet;
use App\Services\BaseServiceInterface;
use App\Models\User;
use App\Services\Utilities\GetHttpRequest;


class ListService implements BaseServiceInterface
{
    protected $data, $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function run()
    {
        $account = Wallet::where("user_id", $this->user->id)->firstOrFail();
         $res = $this->getApiAccount($account->merchant_account_id);
            // if ($res) {
            //     $account['balance'] = $res;
            // } else {
            // }
        return $res;
    }




    private function getApiAccount($id)
    {
        $url = env('BASE_URL') . 'accounts/' . $id. '/transactions';
        $res = new GetHttpRequest($url);
        $res =  $res->run();
        return $res;
    }


    
}
