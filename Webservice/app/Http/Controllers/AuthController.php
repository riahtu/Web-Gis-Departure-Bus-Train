<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
use Auth;

class AuthController extends Controller {

    public function login(Request $request) {
    	if(!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

            return response()->json([
                'message' => 'Invalid login'
            ], 401);

    	} else {

            $user = User::find(Auth::user()->id);
            if(strlen($user->api_token) === 0) {
                $user->update([
                    'api_token' => md5($request->username.time())
                ]);
            }

    		$user = User::find(Auth::user()->id);
    		return fractal()
    			->item($user)
    			->transformWith(new UserTransformer)
    			->addMeta([
    				'token' => $user->api_token,
                    'level' => $user->level,
                    'user' => $user->username
    			])
    			->toArray();
    	}
    }

    public function logout(Request $request) {

        $user = User::find(Auth::user()->id);
        $user->update([
            'api_token' => ''
        ]);

        return response()->json(['message'=>'Logout success'],200);
    }
}
