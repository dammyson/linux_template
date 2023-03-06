<?php

namespace App\Http\Controllers;

use App\Services\Transaction\ListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        try {
            $transactions = new ListService($user);
            $transactions = $transactions->run();
            return response()->json(['status' => true, 'data' => $transactions ,  'message' => 'Transaction  fetched successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => false,  'error'=>$exception->getMessage(), 'message' => 'Error processing request'], 500);
        }
    }
}
