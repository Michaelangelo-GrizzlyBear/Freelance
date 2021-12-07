<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Authenticate extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password )){
            return response([
                'message' =>'Bad Credentials'
            ],401);
        }

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ];
            return response($response, 201);
        // }
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ]);
    }

    public function registration(Request $request){
        $fields = $request->validate([
            'lastname' => 'required|string|max:35',
            'firstname' => 'required|string|max:35',
            'middlename' => 'required|string|max:35',
            'birthDate' => 'required|string',
            'birthPlace' => 'required|string|max:40',
            'suffix' => 'required|string|max:15',
            'sex' => 'required|string|max:10',
            'age' => 'required|string',
            'contact' => 'required|string|max:50',
            'emergencyNo' => 'required|numeric',
            'emergencyContact' => 'required|string|max:35',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // if (User::where('email', '=', Input::get('email'))->exists()) {
        //     return response('Email already exists! ');
        // }

        $user = User::create([
            'lastname' => $fields['lastname'],
            'firstname' => $fields['firstname'],
            'middlename' => $fields['middlename'],
            'birthDate' => $fields['birthDate'],
            'birthPlace' => $fields['birthPlace'],
            'suffix' => $fields['suffix'],
            'sex' => $fields['sex'],
            'age' => $fields['age'],
            'contact' => $fields['contact'],
            'emergencyNo' => $fields['emergencyNo'],
            'emergencyContact' => $fields['emergencyContact'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ];

        return response($response, 201);

    }

    public function myProfile(){
        $myProfile = Auth::user();

        return response()->json($myProfile);
    }

    public function signout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

}