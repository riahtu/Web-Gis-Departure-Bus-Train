<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;

class UserController extends Controller {
   	
   	// public function register(Request $request) {

   	// 	$this->validate($request, [
   	// 		'username' => 'required|min:2|max:125|unique:users',
   	// 		'password' => 'required|min:3',
   	// 	]);

   	// 	$user = User::create([
   	// 		'username' => $request->username,
   	// 		'password' => bcrypt($request->password),
   	// 		'api_token' => '',
   	// 		'level' => 'client'
   	// 	]);

   	// 	$response = fractal()
   	// 		->item($user)
   	// 		->transformWith(new UserTransformer)
   	// 		->toArray();

   	// 	return response()->json($response,201);
   	// }
}
