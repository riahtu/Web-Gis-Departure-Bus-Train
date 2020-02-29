<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {

	public function transform($user) {
		
		return [
			'id' => $user->id,
			'username' => $user->username,
			'registered' => $user->created_at->diffForHumans(),
		];
	}
}