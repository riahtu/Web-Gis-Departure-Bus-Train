<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ScheduleTransformer extends TransformerAbstract {

	public function transform($schedule) {

		return [
			'id' => $schedule->id,
			'type' => $schedule->type,
			'line' => $schedule->line,
			'from_place_id' => $schedule->from_place_id,
			'to_place_id' => $schedule->to_place_id,
			'departure_time' => date('H:i:s',$schedule->departure_time),
			'arrival_time' => date('H:i:s',$schedule->arrival_time),
			'distance' => $schedule->distance,
			'speed' => $schedule->speed
		];
	}
}