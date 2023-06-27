<?php

namespace App\Http\Controllers;

use App\Enums\CustomerRoleEnum;
use App\Enums\UserRoleEnum;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisteringRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function processLogin(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!is_null($user) and Hash::check($request->password, $user->password)) {
            auth()->login($user);
            $role = getRoleByValue(user()->user_role);
            if ($role === "super_admin") {
                $role = "admin";
            }
            return redirect()->route("$role.welcome");
        }
        return redirect()->route('login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registering(RegisteringRequest $Request)
    {
        $current_timestamp  = Carbon::now()->toDateTimeString();
        $password           = Hash::make($Request->password);

        if (auth()->check()) {
            User::where('id', user()->id)
                ->update([
                    'password'      => $password,
                    'created_at'    => $current_timestamp,
                ]);
        } else {
            $user = User::create([
                'name'          => $Request->name,
                'email'         => $Request->email,
                'password'      => $password,
                'created_at'    => $current_timestamp,
            ]);
            Auth::login($user, true);
        }

        $role = getRoleByValue(user()->user_role);
        return redirect()->route("$role.welcome");
    }

    public function callback($provider)
    {
        $data = Socialite::driver($provider)->user();

        $user = User::query()
            ->where('email', $data->getEmail())
            ->first();
        $checkExist = true;

        if (is_null($user)) {
            $user           = new User();
            $user->name     = $data->getName();
            $user->email    = $data->getEmail();
            $checkExist     = false;
        }

        Auth::login($user);
        $roleValue = user()->user_role;

        if ($checkExist) {
            $role = getRoleByValue($roleValue);
            if ($role == "super_admin") {
                return redirect()->route("admin.welcome");
            }
            return redirect()->route("$role.welcome");
        }

        return redirect()->route('register');
    }
}
