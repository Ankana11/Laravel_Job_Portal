<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
   public function registration(){
    return view('front.account.registration');
   }
   public function proccessRegistration(Request $request){
    $vaidator= Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'pass' => 'required|min:5|same:cpass',
        'cpass' => 'required',
    ]);
    if($vaidator->passes()){
$user = new User();
$user->name = $request->name;
$user->email = $request->email;
$user->password = Hash::make($request->pass);

$user->save();

session()->flash('success','You Have Register Successfully');

    }  
    else{
    return response()->json([
    'status'=> false,
    'errors'=> $vaidator->errors()

    ]);
    }
 }
   public function login(){
      return view('front.account.login');
   }
}
