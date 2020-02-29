<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {
    
    protected $fillable = [ 'type','line','from_place_id','to_place_id','departure_time','arrival_time','distance','speed' ];
}
