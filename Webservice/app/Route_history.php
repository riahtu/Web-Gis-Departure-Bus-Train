<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route_history extends Model {
    
    protected $fillable = ['from_place_id','to_place_id','schedule_id','frekuensi'];
}
