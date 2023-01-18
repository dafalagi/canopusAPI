<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Register user
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->validated();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('CanopusID')->plainTextToken;
        $success['user'] =  $user;
   
        return $this->sendResponse($success, 'User registered successfully.');
    }
   
    /**
     * Login user
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(Auth::attempt($credentials)){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('CanopusID')->plainTextToken; 
            $success['user'] =  $user;
   
            return $this->sendResponse($success, 'User logged in successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        } 
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse(null, 'User logged out successfully');
    }
}
