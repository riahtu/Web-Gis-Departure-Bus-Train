<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Schedule;
use App\Route_history;
use App\Transformers\RouteTransformer;
use App\Transformers\HistoryTransformer;

class RouteController extends Controller {

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
        header("Access-Control-Allow-Origin: http://localhost:8080");
	}

    public function search($from_place_id,$to_place_id,$departure_time='default') {
    	
    	if($departure_time == 'default') {
    		$departure_time = time();
    	} elseif(!preg_match("/\d{1,2}:{1}\d{1,2}:{1}\d{1,2}/", $departure_time)) {
            return response()->json(['message'=>'Date format is vailed'],402);
        } else {
    		$departure_time = $this->MKTIME($departure_time);
    	}

    	$route = DB::table('schedules')
    		->where('from_place_id',$from_place_id)
    		->where('to_place_id',$to_place_id)
    		->where('departure_time','>=',$departure_time)
    		->select()
    		->orderBy('departure_time','ASC')
    		->limit(5)
    		->get();

    	return fractal()
    		->collection($route)
    		->transformWith(new RouteTransformer)
    		->toArray();
    }

    public function createHistory(Request $request) {
    	
    	$this->validate($request, [
    		'from_place_id' => 'required',
			'to_place_id' => 'required',
			'schedule_id' => 'required'
    	]);

    	// cek apakah route ini sudah ada di history
    	$data = DB::table('route_histories')
    		->where('from_place_id',$request->from_place_id)
    		->where('to_place_id',$request->to_place_id);
    	$cek = $data->exists();

    	if($cek === true) {
    		$this->updateHistoryRoute($request,$data->get());
    	} else {
    		DB::table('route_histories')->insert([
    			'from_place_id' => $request->from_place_id,
				'to_place_id' => $request->to_place_id,
				'schedule_id' => $request->schedule_id,
				'frekuensi' => 1,
                'user' => $request->user
    		]);
    	}

        return response()->json('History created',201);
    }

    public function updateHistoryRoute($request,$data) {

    	$arrSchedule_id = explode(",", $data[0]->schedule_id);
    	if(in_array($request->schedule_id, $arrSchedule_id)) {
    		$schedule_id = $data[0]->schedule_id;
    	} else {
    		$schedule_id = $data[0]->schedule_id.",".$request->schedule_id;
    	}

    	DB::table('route_histories')
    		->where('from_place_id',$request->from_place_id)
    		->where('to_place_id',$request->to_place_id)
	    	->update([
	    		'from_place_id' => $request->from_place_id,
				'to_place_id' => $request->to_place_id,
				'schedule_id' => $schedule_id,
				'frekuensi' => $data[0]->frekuensi+1,
                'user' => $request->user
	    	]);
    }

    public function getHistoryWhereUser($user) {

        $queryFrom = DB::table('route_histories');
        $queryTo = DB::table('route_histories');
        if($queryFrom->exists()) {
            $from_place = $queryFrom
                ->join('places','route_histories.from_place_id','=','places.id')
                ->where('route_histories.user','=',$user)
                ->orderBy('frekuensi','ASC')
                ->select('route_histories.from_place_id','route_histories.user','places.name')
                ->get();
            $from_placeF = fractal()
                ->collection($from_place)
                ->transformWith(new HistoryTransformer)
                ->toArray();

            $to_place = $queryTo
                ->join('places','route_histories.to_place_id','=','places.id')
                ->where('route_histories.user','=',$user)
                ->orderBy('frekuensi','ASC')
                ->select('route_histories.to_place_id','route_histories.user','places.name')
                ->get();
            $to_placeF = fractal()
                ->collection($to_place)
                ->transformWith(new HistoryTransformer)
                ->toArray();

            $hasil = array_merge($from_placeF['data'],$to_placeF['data']);
            return response()->json(['data'=>$hasil],200);
        } else {
            return response()->json(['data'=>[]],200);
        }
    }

    public function getHistoryWhereUserOther($user) {

        $queryFrom = DB::table('route_histories');
        $queryTo = DB::table('route_histories');
        if($queryFrom->exists()) {
            $from_place = $queryFrom
                ->join('places','route_histories.from_place_id','=','places.id')
                ->where('route_histories.user','!=',$user)
                ->orderBy('frekuensi','DESC')
                ->select('route_histories.from_place_id','route_histories.user','places.name')
                ->get();
            $from_placeF = fractal()
                ->collection($from_place)
                ->transformWith(new HistoryTransformer)
                ->toArray();

            $to_place = $queryTo
                ->join('places','route_histories.to_place_id','=','places.id')
                ->where('route_histories.user','!=',$user)
                ->orderBy('frekuensi','DESC')
                ->select('route_histories.to_place_id','route_histories.user','places.name')
                ->get();
            $to_placeF = fractal()
                ->collection($to_place)
                ->transformWith(new HistoryTransformer)
                ->toArray();
            $hasil = array_merge($from_placeF['data'],$to_placeF['data']);
            return response()->json(['data'=>$hasil],200);
        } else {
            return response()->json(['data'=>[]],200);
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