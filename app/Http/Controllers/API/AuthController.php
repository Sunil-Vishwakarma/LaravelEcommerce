<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends BaseController
{
    // Registration

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric||unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails())
        {
            return $this->sendError('Field Validation Error.', $validator->errors()->all());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['id'] =  $user->id;
        $success['name'] =  $user->name;
        $success['token'] =  $user->createToken('MyLaravelTestApp')->accessToken;
   
        return $this->sendResponse($success, 'User register successfully.');
    }

    // Login

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
   
        if($validator->fails())
        {
            return $this->sendError('Field Validation Error.', $validator->errors()->all());       
        }
        
        if(Auth::attempt(['email' => trim($request->email), 'password' => trim($request->password)]))
        { 
            $user = Auth::user();  
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['token'] =  $user->createToken('MyLaravelTestApp')->accessToken;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else
        { 
            return $this->sendError('Unauthorised.', ['error'=>'Invalid email or password !']);
        }
    }
}
