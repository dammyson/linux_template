<?php

namespace App\Services\Utilities;

use App\Services\BaseServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetHttpRequest implements BaseServiceInterface
{
    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function run()
    {
        try {
              $response = Http::withToken(env('TOKEN', "this"))
              ->withHeaders(['Content-Type' => 'application/json'])
              ->get($this->url);

              $c1 = $response->failed();
              $c2 = $response->clientError();
              $c3 = $response->serverError();

           if ($c1 or $c2 or $c3){
               Log::info("::::::::::::::::::::::::::::: API CALL FAIL WITH Errors ");
               return false;
             }else{
               Log::info($response->body());
               Log::info("::::::::::::::::::::::::::::: API CALL FINISHED SUCCESFULY");
               return json_decode($response->body());
             }
              
        } catch (\Exception $e) {
            return false;
        }
        
    }  
}