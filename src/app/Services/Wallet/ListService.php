<?php

namespace App\Services\Wallet;

use App\Models\Wallet;
use App\Services\BaseServiceInterface;
use App\Models\User;
use App\Services\Utilities\GetHttpRequest;
use App\Services\Utilities\PostHttpRequest;
use Exception;
use Illuminate\Support\Facades\Log;

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
            if ($res) {
                $account['balance'] = $res;
            } else {
            }
        return  $account ;
    }




    private function getApiAccount($id)
    {
        $url = env('BASE_URL') . 'accounts/' . $id. '/balance';
        $res = new GetHttpRequest($url);
        $res =  $res->run();
        return $res;
    }


    
}
