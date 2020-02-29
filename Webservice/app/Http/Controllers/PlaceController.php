<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use App\Transformers\PlaceTransformer;
use Auth;

class PlaceController extends Controller {
   	
   	public function index(Request $request) {
   
   		$places = Place::all();
   		return fractal()
   			->collection($places)
   			->transformWith(new PlaceTransformer)
   			->toArray();
   	}

   	public function placeById($id) {

   		$place = Place::find($id);
         if($place) {
      		return fractal()
      			->item($place)
      			->transformWith(new PlaceTransformer)
      			->toArray();
         } else {
            return response()->json(['message' => 'Data not found'], 404);
         }
   	}

   	public function createPlace(Request $request, Place $place) {

   		$this->authorize('chekLevel', $place);
   		
   		$this->validate($request, [
   			'name' => 'required|unique:places',
   			'latitude' => 'required',
   			'longitude' => 'required',
   			'x' => 'required',
   			'y' => 'required',
   			'img_path' => 'required',
   			'description' => 'required',
   		]);

   		$place->create([
      		'name' => $request->name,
   			'latitude' => $request->latitude,
   			'longitude' => $request->longitude,
   			'x' => $request->x,
   			'y' => $request->y,
   			'img_path' => $request->img_path,
   			'description' => $request->description
   		]);

   		return response()->json(['message' => 'Data created'], 201);
   	}

   	public function deletePlace(Request $request, $id) {
   		
   		$place = Place::find($id);
   		if($place) {
   			$this->authorize('chekLevel', $place);
   		} else {
   			return response()->json(['message'=>'Data cannot be deleted'],400);
         }

   		$place->delete();

   		return response()->json(['message'=>'delete success'], 200);
   	}

   	public function editPlace(Request $request, $id) {
   		
   		$place = Place::find($id);
   		if($place) {
   			$this->authorize('chekLevel', $place);
         } else {
   			return response()->json(['message'=>'Data cannot be updated'],400);
         }

   		$this->validate($request, [
   			'name' => 'required|unique:places',
   			'latitude' => 'required',
   			'longitude' => 'required',
   			'x' => 'required',
   			'y' => 'required',
   			'description' => 'required',
   		]);

   		$place->update([
   			'name' => $request->name,
   			'latitude' => $request->latitude,
   			'longitude' => $request->longitude,
   			'x' => $request->x,
   			'y' => $request->y,
   			'img_path' => $request->img_path??$place->img_path,
   			'description' => $request->description,
   		]);

   		return response()->json(['message'=>'Data updated'], 200);
   	}
}