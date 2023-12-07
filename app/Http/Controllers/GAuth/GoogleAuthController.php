<?php

namespace App\Http\Controllers\GAuth;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        try{
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())->first();

            if(!$user)
            {
                $getUser = User::create([
                    'first_name' => ucfirst($googleUser->offsetGet('given_name')),
                    'last_name' => ucfirst($googleUser->offsetGet('family_name')),
                    'email' => $googleUser->getEmail(),
                    'email_verified_at' => now(),
                    'password' => null,
                    'user_role' => UserRole::Guest,
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'remember_token' => Str::random(10)
                ]);

                Auth::login($getUser);
                return redirect()->intended('/admin/users');
            }else{
                Auth::login($user);
                return redirect()->intended('/admin/users');
            }


        }catch(Exception $e)
        {
            dd($e->getMessage());
        }
    }
}
