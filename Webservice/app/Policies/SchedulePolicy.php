<?php

namespace App\Policies;

use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class SchedulePolicy
{
    use HandlesAuthorization;

    public function chekLevel() {
        return Auth::user()->level == 'admin';
    }
}
