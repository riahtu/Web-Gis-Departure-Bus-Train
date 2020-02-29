<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;
use App\User;

class PlacePolicy
{
    use HandlesAuthorization;

    public function chekLevel() {
        return Auth::user()->level == 'admin';
    }
}
