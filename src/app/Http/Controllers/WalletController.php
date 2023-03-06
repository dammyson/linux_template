<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wallet\CreateRequest;
use App\Http\Requests\Wallet\TransferRequest;
use App\Services\Wallet\CreateService;
use App\Services\Wallet\ListService;
use App\Services\Wallet\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class WalletController extends Controller
{
    public function create(CreateRequest $request)
    {
   
        $validated = $request->validated();
        $user = Auth::user();
        try {
            $new_card = new CreateService($validated, $user);
            $new_card = $new_card->run();
            return response()->json(['status' => true, 'data' => $new_card ,  'message' => 'registration successful'], 201);
        } catch (\Exception $exception) {
            return response()->json(['status' => false,  'error'=>$exception->getMessage(), 'message' => 'Error processing request'], 500);
        }
    }

    public function index(){
        $user = Auth::user();

        try {
            $new_card = new ListService($user);
            $new_card = $new_card->run();
            return response()->json(['status' => true, 'data' => $new_card ,  'message' => 'Wallet  fetched successfully'], 201);
        } catch (\Exception $exception) {
            return response()->json(['status' => false,  'error'=>$exception->getMessage(), 'message' => 'Error processing request'], 500);
        }
    }

    public  function transfer(TransferRequest $request){
        $validated = $request->validated();
        $user = Auth::user();
        try {
            $new_card = new TransferService($validated,  $user);
            $new_card = $new_card->run();
            return response()->json(['status' => true, 'data' => $new_card ,  'message' => 'registration successful'], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => false,  'error'=>$exception->getMessage(), 'message' => 'Error processing request'], 500);
        }

    }

    public function getWalletOwner($id)
    {
        $wallet_owner = DB::table('wallets')
                ->join('users', 'wallets.user_id', '=', 'users.id')
                ->select('users.id', 'users.first_name', 'users.last_name', 'users.user_id', 'wallets.id As wallet_id')
                ->where('wallets.qr_code', $id)
                ->orWhere('users.user_id', $id)
                ->first();
        if ($wallet_owner) {
            return response()->json([ 'data' => $wallet_owner ], 200);
        }
        return response()->json([ 'message' => "Unable to get user details" ], 400);
    }
}
