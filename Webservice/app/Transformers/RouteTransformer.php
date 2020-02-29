<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Place;
use App\Schedule;
use App\Route_history;

class RouteTransformer extends TransformerAbstract {

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
	}

	public function transform($route) {

		$from_place = Place::find($route->from_place_id);
		$to_place = Place::find($route->to_place_id);

    	return [
    		'number_selection' => $this->get_jmlSelection($route->from_place_id,$route->to_place_id),
    		'schedules' => [
    			'schedule_id' => $route->id,
				'type' => $route->type,
				'line' => $route->line,
				'departure_time' => date('H:i:s',$route->departure_time),
				'arrival_time' => date('H:i:s',$route->arrival_time),

				'travel_time' => $this->travel_time($route->departure_time,$route->arrival_time),

				'from_place' => [ 'id' => $from_place->id, 'name' => $from_place->name, 'longitude' => $from_place->longitude, 'latitude' => $from_place->latitude, 'x'=>$from_place->x, 'y'=>$from_place->y, 'description' => $from_place->description, 'image_path' => $from_place->img_path ],
				'to_place' => [ 'id' => $to_place->id, 'name' => $to_place->name, 'longitude' => $to_place->longitude, 'latitude' => $to_place->latitude, 'x'=>$to_place->x, 'y'=>$to_place->y, 'description' => $to_place->description, 'image_path' => $to_place->img_path ],
    		],
    	];
	}

	public function travel_time($departure_time,$arrival_time) {

		$selisih = $arrival_time-$departure_time;
		$jam = ceil($selisih/(60*60));
		$menit = ceil($selisih/60);
		$detik = $selisih;

		if($detik <= 0) {
			return "traveled";
		} else if($detik <= 59) {
			return $detik." Second";
		} else if($menit <= 59) {
			return $menit." Minutes";
		} else if($jam <= 23) {
			return $jam." Hours";
		} else {
			return "Next Day";
		}
	}

	public function get_jmlSelection($from_place_id,$to_place_id) {
		return Route_history::find([$from_place_id,$to_place_id])[0]->frekuensi??0;
	}
}