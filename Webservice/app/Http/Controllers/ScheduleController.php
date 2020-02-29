<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use App\Transformers\ScheduleTransformer;
use Auth;
use App\Rules\Must_same;

class ScheduleController extends Controller {

    public function __construct() {
        date_default_timezone_set("Asia/Jakarta");
    }
    
    public function index() {

    	$schedule = Schedule::all();
    	return fractal()
    		->collection($schedule)
    		->transformWith(new ScheduleTransformer)
    		->toArray();
    }

    public function createSchedule(Request $request, Schedule $schedule) {
    	
    	$this->authorize('chekLevel',$schedule);

    	$this->validate($request, [
    		'type' => ['required','string',new Must_same],
			'line' => 'required',
			'from_place_id' => 'required',
			'to_place_id' => 'required',
			'departure_time' => 'required|date_format:H:i:s',
			'arrival_time' => 'required|date_format:H:i:s',
			'distance' => 'required',
			'speed' => 'required'
    	]);

    	$schedule->create([
    		'type' => $request->type,
			'line' => $request->line,
			'from_place_id' => $request->from_place_id,
			'to_place_id' => $request->to_place_id,
			'departure_time' => $this->MKTIME($request->departure_time),
			'arrival_time' => $this->MKTIME($request->arrival_time),
			'distance' => $request->distance,
			'speed' => $request->speed
    	]);

    	return response()->json(['message'=>'data created'],201);
    }

    public function deleteSchedule($id) {
    	
    	$schedule = Schedule::find($id);
    	if($schedule) {

    		$this->authorize('chekLevel',$schedule);
    		$schedule->delete();

    		return response()->json(['message'=>'data deleted'],200);
    	} else {
    		return response()->json(['message'=>'data not found'],404);
    	}
    }

    public function MKTIME($time) {

        $date = explode(",",date("m,d,Y"));
        $bulan = (int)$date[0];
        $hari = (int)$date[1];
        $tahun = (int)$date[2];

        $time = explode(":",$time);
        $jam = $time[0];
        $menit = $time[1];
        $detik = $time[2];

        return mktime($jam,$menit,$detik,$bulan,$hari,$tahun);
    }
}
