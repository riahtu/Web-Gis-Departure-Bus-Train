<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

use GuzzleHttp\Client;
// use GuzzleHttp\Exception\RequestException;
// use Guzzle\Http\Exception\ClientErrorResponseException;
// use GuzzleHttp\Exception\ServerException;
// use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;

class WelcomeController extends Controller {
      protected $client;

      public function __construct() {
         $this->client = new Client([
            'base_uri'=>'http://localhost:8000/api/',
            'headers'=>['accept' => 'applicaiton/json']
         ]);
      }
   
   	public function index() {

         $api_token = 'umum';
         if(session()->has('WebclientSession')) {
            $api_token = session()->get('WebclientSession')['api_token'];
         }

         try {
            $placeResponse = $this->client->get('place', [
               'query' => [ 
                  'api_token' => $api_token
               ]
            ]);
            $place = json_decode($placeResponse->getBody()->getContents(), true)['data'];
            
            // jika user login
            if(session()->has('WebclientSession')) {
               $user = session()->get('WebclientSession')['user'];
               $historyWhereUserResponse = $this->client->get('route/historyWhereUser/'.$user, [
                  'query' => [ 
                     'api_token' => $api_token
                  ]
               ]);
               $historyWhereUserOtherResponse = $this->client->get('route/HistoryWhereUserOther/'.$user, [
                  'query' => [ 
                     'api_token' => $api_token
                  ]
               ]);

               $historyWhereUser = json_decode($historyWhereUserResponse->getBody()->getContents(), true)['data'];
               $historyWhereUserOther = json_decode($historyWhereUserOtherResponse->getBody()->getContents(), true)['data'];

               $historyPlace = $this->generateHistoryPlace($historyWhereUser,$historyWhereUserOther);

               return view('welcome', ['place'=>$place,'historyPlace'=>$historyPlace]);

            // jika user tidak login
            } else {
               return view('welcome', ['place'=>$place]);
            }

         } catch (ClientException $e) {
            return view('welcome');
         }
   	}

      public function generateHistoryPlace($historyWhereUser,$historyWhereUserOther) {
         $history = array_merge($historyWhereUser,$historyWhereUserOther);
         $hasil = [];
         for($i=0;$i<count($history);$i++){
            if(count($hasil) == 0) {
               array_push($hasil, $history[$i]);
            } else {
               if(!$this->cekHasHistory($hasil,$history,$i)) {
                  array_push($hasil,$history[$i]);
               }
            }
         }
         return $hasil;
      }

      public function cekHasHistory($hasil,$history,$i) {
         for($j=0;$j<count($hasil);$j++) {
            if($history[$i]['place_id'] == $hasil[$j]['place_id']) {
               return true;
            }
         }

         return false;
      }

   	public function login(Request $request) {

         $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
         ]);

         try {
            $response = $this->client->post('auth/login', [
               'form_params' => [
                  'username' => $request->username,
                  'password' => $request->password
               ]
            ]);

            $data = $response->getBody()->getContents();
            $arr = json_decode($data);
            Session::put('WebclientSession',[ 'api_token' => $arr->meta->token, 'level' => $arr->meta->level, 'user' => $arr->meta->user ]);
            return redirect()->route('index');

         } catch (ClientException $e) {

            $error = $e->getMessage();
            $awal = strpos($error,"{");

            $pesanM = substr($error, $awal);
            $arr = explode(":", $pesanM);
            $pesan = str_replace(['"',"}"], "", end($arr));

            return redirect()->route('index')->with( ['data' => $pesan] );
         }
   	}

      public function logout() {

         $this->client->post('auth/logout', [
            'query' => [ 
               'api_token' => session()->get('WebclientSession')['api_token']
            ]
         ]);

         session()->forget('WebclientSession');
         return redirect()->route('index');
      }
}