<?php

namespace App\Http\Controllers;

use App\Mail\HelloMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\LoginNotification;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\select;

class UserController extends Controller
{

    //----------------------------------------------------------------
    
    public function Register(Request $request){
        
        //check if request email is created already
        if (User::query()->where('email', '=', $request['email'])->first())
        {
            return response()->json(['message' =>'Please change your email address']);
        }
        //validate
        $data =Validator::make($request->all(), [
            'first_name'=>'required|min:3',
            'last_name'=>'required|min:3',
            'nationality'=>'required',
            'gender'=>'required',
            'phone'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:10',
        ]);
        if($data->fails())
        {
            return response()->json([
                'message' =>$data->errors(),
                'status' =>404
            ]);
        }  
        $imageUrl = null;
        if ($request->hasFile('image')) 
        {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/user/images', $imageName);
            $imageUrl = Storage::url($path);
        }
        //create a new account
        $user =User::create([
            'first_name' =>$request['first_name'],
            'last_name' =>$request['last_name'],
            'nationality'=>$request['nationality'],
            'gender'=>$request['gender'],
            'phone'=>$request['phone'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password']),
            'image' => $imageUrl ?? null
        ]);
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'message'=> 'created successfully',
            'token' => $token,
            'status'=>200
        ]);
    }
    
    //----------------------------------------------------------------

    public function login(Request $request){
      
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) 
        {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 401
            ]);
        }
        
        // Create login token
        $loginToken = $user->createToken('loginToken')->plainTextToken;
         $user->notify(new LoginNotification());
         $user->notify(new EmailVerificationNotification());
        return response()->json([
            'token' => $loginToken,
            'message' => 'Logged in successfully',
            'status' => 200,
        ]);
        
        // $helloMail = new HelloMail();
        // Mail::to($user->email)->send($helloMail);
        // // Check if user is already logged in
        // if ($user->tokens()->where('name', 'loginToken')->exists()) 
        // {
        //     return response()->json([
        //         'message' => 'User is already logged in',
        //         'status' => 422
        //     ]);
        // }
    }

    
    //----------------------------------------------------------------
    
    public function logout() 
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' =>'logout successfully',
            'status' =>200
        ]);
    }

    //----------------------------------------------------------------

    public function profile()
    {
      $user = User::query()->find(Auth::user()->id);
      if(!$user)
    {
        return response()->json([
            'message' => 'invalid user',
            'status' =>422
        ]);
    }
      else{
      $data = $user->toArray();
      return response()->json([
        'message' => 'user profile',
        'data' => $data,
        'status'=>200
      ]);

    }

    }

    
}






    /*
        //validate
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        //cheack user
        $user = User::query()->where('email', '=', $request['email'])->first();
        
        if ($user) {
            //cheack password
            if (Hash::check($request->password, $user->password)) {
                //cheack if user is loggin already 
                if ($user->tokens()->exists()) {
                    return response()->json([
                        'message' => 'User is already logged in',
                        'status' => 422
                    ]);
                }
                
                
                    //$user->notify(new EmailVerificationNotification());
                 
                $token = $user->createToken('authToken')->plainTextToken; 
                //$user->notify(new LoginNotification());
                
                return response()->json([
                    'token' => $token,
                    'message' => 'Logged in successfully',
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Password is incorrect',
                    'status' => 422
                ]);
            }
        } else {
            return response()->json([
                'message' => 'User not found',
                'status' => 404
            ]);
        }*/
    