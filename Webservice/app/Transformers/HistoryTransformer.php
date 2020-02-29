<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Route_history;

class HistoryTransformer extends TransformerAbstract {

	public function transform($history) {
		return [
			'place_id' => $history->from_place_id??$history->to_place_id,
			'name' => $history->name,
			'user' => $history->user
		];
	}
}