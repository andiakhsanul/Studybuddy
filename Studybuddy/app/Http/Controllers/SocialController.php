<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    function redirect()
    {
        return Socialite::driver('google')
            ->redirect();
    }
    function GoogleCallback(){
        $user = Socialite::driver('google')->user();
        dd($user);

    }
}

