<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

use GuzzleHttp\Client;
// use GuzzleHttp\Exception\RequestException;
// use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ServerException;
// use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;

class PlaceController extends Controller {

	protected $client;

    public function __construct() {
        $this->client = new Client([
            'base_uri'=>'http://localhost:8000/api/',
            'headers'=>['accept' => 'applicaiton/json']
       	]);
    }
    
    public function index() {
    	$request = $this->client->get('place',[
    		'query' => [
    			'api_token' => session()->get('WebclientSession')['api_token']
    		]
    	]);
    	$data = json_decode($request->getBody()->getContents(), true)['data'];
    	return view('place', ['data' => $data]);
    }

    public function add() {
    	return view('addPlace');
    }

    public function addProses(Request $request) {

    	$this->validate($request, [
    		'name' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
			'x' => 'required',
			'y' => 'required',
			'img_path' => 'required',
			'description' => 'required'
    	]);

    	try {
    		$response = $this->client->post('place', [
	    		'query' => [
	    			'api_token' => session()->get('WebclientSession')['api_token']
	    		],
	    		'form_params' => [
	    			'name' => $request->name,
					'latitude' => $request->latitude,
					'longitude' => $request->longitude,
					'x' => $request->x,
					'y' => $request->y,
					'img_path' => $request->img_path,
					'description' => $request->description
	    		]
	    	]);

    	} catch (ClientException $e) {
    		$error = $e->getMessage();
            $awal = strpos($error,"{");

            $pesanM = substr($error, $awal);
            $arr = explode(":", $pesanM);
            $pesan = str_replace(['"',"}","[","]"], "", end($arr));

            return redirect()->route('addPlace')->with( ['pesan' => $pesan] );
            exit();
    	}

    	return redirect()->route('place');
    }

    public function edit($id) {

        $response = $this->client->get('place/'.$id, [
            'query' => [
                'api_token' => session()->get('WebclientSession')['api_token']
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true)['data'];
        return view('editPlace', ['data' => $data]);
    }

    public function editProses(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'x' => 'required',
            'y' => 'required',
            'img_path' => 'required',
            'description' => 'required'
        ]);

        try {
            $response = $this->client->put('place/'.$request->id, [
                'query' => [
                    'api_token' => session()->get('WebclientSession')['api_token']
                ],
                'form_params' => [
                    'name' => $request->name,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'x' => $request->x,
                    'y' => $request->y,
                    'img_path' => $request->img_path,
                    'description' => $request->description
                ]
            ]);

        } catch (ClientException $e) {
            $error = $e->getMessage();
            $awal = strpos($error,"{");

            $pesanM = substr($error, $awal);
            $arr = explode(":", $pesanM);
            $pesan = str_replace(['"',"}","[","]"], "", end($arr));

            return redirect('editPlace/'.$request->id)->with( ['pesan' => $pesan] );
            exit();
        }

        return redirect()->route('place');
    }

    public function delete($id) {
    	
    	try {
            $response = $this->client->delete('place/'.$id, [
                'query' => [
                    'api_token' => session()->get('WebclientSession')['api_token']
                ]
            ]);  
        } catch (ServerException $e) {

            return redirect()->route('place')->with( ['pesan' => 'Data cannot be deleted'] );
            exit();
        }

    	return redirect()->route('place');
    }
}
