<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class PlaceTransformer extends TransformerAbstract {

	public function transform($place) {

		return [
			'id' => $place->id,
			'name' => $place->name,
			'latitude' => $place->latitude,
			'longitude' => $place->longitude,
			'x' => $place->x,
			'y' => $place->y,
			'img_path' => $place->img_path,
			'description' => $place->description,
			'created_at' => $place->created_at->diffForHumans()
		];
	}
}