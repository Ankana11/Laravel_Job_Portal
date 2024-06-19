<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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

   public function authenticate(Request $request){
$validator= Validator::make($request->all(),[
   'email' => 'required|email',
   'pass' => 'required'
]);

if($validator->passes()){

   if(Auth::attempt(['email' => $request->email, 'password' => $request->pass])){
      return redirect()->route('account.profile');
   }else{
return redirect()->route('account.login')->with('error','Either Email/password is incorrect');
   }

}else{
   return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
}
   }

   public function profile(){

    $id = Auth::user()->id;
    $user = User::where('id',$id)->first();
//we ca use find method to fetch data

   //  $user = User::find($id);
   //  dd($user);

      return view('front.account.profile',[
         'user' => $user
      ]);
   }

   public function updateprofile(Request $request){
      $id = Auth::user()->id;
      $validator = Validator::make($request->all(),[
         'name' => 'required',
         'email' => 'required|email|unique:users,email,'.$id.',id'
      ]);
      if($validator->passes()){
         $user = User::find($id);
         $user->name = $request->name;
         $user->email = $request->email;
         $user->mobile = $request->mobile;
         $user->designation = $request->designation;
         $user->save();

session()->flash('success','Your profle updated successfully');

         return response()->json([
            'status'=>'true',
            'errors' =>[]
         ]);
      }else{
         return response()->json([
            'status'=>'false',
            'errors' =>$validator->errors()
         ]);
      }
   }
   
   public function logout(){
      Auth::logout();
      return redirect()->route('account.login');
   }

   public function updateprofilepic(Request $req){
      $id = Auth::user()->id;
      $validator = Validator::make($req->all(),[
         'image' => 'required|image'
         
      ]);
      if($validator->passes()){
         $image= $req->file('image');
         $ext= $image->getClientOriginalExtension();
         $imagename= $id.'-'.time().'.'.$ext;
         $image->move(public_path('profilepic/'), $imagename);

         File::delete(public_path('profilepic/'.Auth::user()->image));

         User::where('id',$id)->update(['image' => $imagename]);
         session()->flash('success','Your profle picture updated successfully');
         return response()->json([
            'status'=>'true',
            'errors' =>[]
         ]);

      }else{
         return response()->json([
            'status'=>'false',
            'errors' =>$validator->errors()
         ]);
      }
   }
}
