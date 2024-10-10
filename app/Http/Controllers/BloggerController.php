<?php

namespace App\Http\Controllers;

use App\Models\Blogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BloggerController extends Controller
{

    //----------------------------------------------------------------
    public function register(Request $request)
    {
        if(Blogger::query()->where('email', '=', $request['email'])->first())
        {
            return response()->json([
                'message' => 'Please change your email address'
            ]);
        }
        
        //Validate
        $data = Validator::make($request->all(),[
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:bloggers',
            'password' => 'required|min:10',
            'nationality'=>'required',
            'gender' => 'required',
            'phone' => 'required',
            'image' => 'required',
            'category_id' => 'required'
        ]);
        if($data->fails())
        {
            return response()->json([
                'message' => $data->errors(),
                'status' =>404
            ]);
        }
         // Handle image upload
        if ($request->hasFile('image')) 
         {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/blogger/images', $imageName);
            $imageUrl = Storage::url($path);
        }

        //create a new account bloggers

        $blogger = Blogger::create([
            'first_name'=> $request['first_name'],
            'last_name'=> $request['last_name'],
            'email'=> $request['email'],
            'password'=> Hash::make($request['password']),
            'nationality'=> $request['nationality'],
            'gender'=> $request['gender'],
            'phone'=> $request['phone'],
            'image' => $imageUrl ?? null,
            'category_id' => $request['category_id']
        ]);
        $token = $blogger->createToken('authToken')->plainTextToken;
        return response()->json([
            'token' => $token,
            'message' => 'created successfully',
            'status' => 200
        ]);
    }
    
    //----------------------------------------------------------------
  
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $blogger = Blogger::where('email', $request->email)->first();
        if (!$blogger || !Hash::check($request->password, $blogger->password)) 
        {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 401
            ]);
        }
    
        // Check if user is already logged in
        if ($blogger->tokens()->where('name', 'loginToken')->exists()) 
        {
            return response()->json([
                'message' => 'Blogger is already logged in',
                'status' => 422
            ]);
        }
    
        // Create login token
        $loginToken = $blogger->createToken('loginToken')->plainTextToken;
        return response()->json([
            'token' => $loginToken,
            'message' => 'Logged in Successfully',
            'status' => 200
        ]);
    }

    //----------------------------------------------------------------
    
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message'=> 'Logged out Successfully',
            'status'=>200
        ]);
    }
    
    //----------------------------------------------------------------
    
    public function profile() 
    {
        $blogger = Blogger::query()->find(Auth::user()->id);
        if (!$blogger) 
        {
            return response()->json([
                'message' => 'Invalid Blogger',
                'status' => 401
            ]);
        }
         else{
            $data = $blogger->toArray();
            return response()->json([
                'message' => 'Blogger profile',
                'data' => $data,
                'status' => 200
            ]);
        }
    }
}



//طريقة تانية لعرض البروفايل

// public function profile(){
        
    // //find id of blogger
    
    // $blog = Blogger::query()->find(Auth::user()->id);
    // $blogger = Blogger::query()->where('id', '=', $blog->id)->get();

    //     //cheack if blogger isset
        
    //     if(!isset($blogger)){
    //         return response()->json([
    //         'message' => 'invalid Blogger',
    //         'status' => 422
    //         ]);
    //     }else{
    //         $b=[];
    //         foreach($blogger as $item){
    //             $zain = Blogger::query()->where('id','=', $item->id)->first();
    //             array_push($b,$zain);
    //         }
    //         return response()->json([
    //             'message' => 'Bloger profile',
    //             'data'=>$b,
    //             'status' => 200
    //         ]);
    //     }


    // }     