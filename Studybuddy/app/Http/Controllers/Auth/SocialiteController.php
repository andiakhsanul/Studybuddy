<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\Users; // Corrected model name
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProvideCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            return redirect()->back();
        }
        // find or create user and send params user get from socialite and provider
        $authUser = $this->findOrCreateUser($user, $provider);

        // login user
        Auth::login($authUser, true); // Corrected Auth() to Auth::

        // setelah login redirect ke dashboard
        return redirect()->route('dashboard');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        // Get Social Account
        $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        // Jika sudah ada
        if ($socialAccount) {
            // return user
            return $socialAccount->user;
        } else {
            // User berdasarkan email
            $user = Users::where('EMAIL', $socialUser->getEmail())->first(); // Updated column name

            // Jika Tidak ada user
            if (!$user) {
                // Create user baru
                $user = Users::create([
                    'NAMA'  => $socialUser->getName(), // Updated column name
                    'EMAIL' => $socialUser->getEmail()
                ]);
            }

            // Buat Social Account baru
            $user->socialAccounts()->create([
                'provider_id'   => $socialUser->getId(),
                'provider_name' => $provider
            ]);

            // return user
            return $user;
        }
    }
}
