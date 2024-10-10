<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerficationRequest;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;


class EmailVerficationController extends Controller
{
    private $otp;
    public function __construct(){
        $this->otp =new Otp();
    }
    
    
    public function sendEmailVerfication(Request $request){
        $request->user()->notify(new EmailVerificationNotification());
        return response()->json([
            'status' => 'success'
        ]);
    }


    public function email_verfication(EmailVerficationRequest $request){
        $otp2 = $this->otp->validate($request->email, $request->otp);
        if(!$otp2->status){
            return response()->json(['error' =>'error'],401);
        }
        $user = User::where('email', $request->email)->first();
        $user->update([
            'email_verified_at' => now()
        ]);
        return response()->json([
            'status' => 'success'
        ],200);
    }
}
