<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use GeneralTrait;
    // Register
    public function register(RegisterRequest $request)
    {
        $newUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => 'user',
            'password' => bcrypt($request->input('password')),
        ]);

        $newUser->makeHidden(['created_at', 'updated_at']);
        $newUser->token = $newUser->createToken('MyApp')->plainTextToken;
        $newUser->assignRole('user');
        return $this->buildResponse($newUser,'Success','register successfully', 200);
    }
    // Login
    public function login(LoginRequest $request){
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return $this->buildResponse('null', 'Error', 'Not found user', 404);
        }
        if (!Hash::check($request->input('password'), $user->password)) {
            return $this->buildResponse('null', 'Error', 'Please check validate username or password', 404);
        }
        $user->token = $user->createToken('token')->plainTextToken;
        $user->makeHidden(['created_at', 'updated_at','email_verified_at']);

        return $this->buildResponse($user, 'Success', 'Login successfully', 200);

    }

    // Logout

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return $this->buildResponse([], 'Success', 'logout successfully', 200);

    }
}
