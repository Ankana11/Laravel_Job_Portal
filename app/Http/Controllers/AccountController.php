<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
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

   public function createJob(){
     $categories = Category::orderBy('name','ASC')->where('status',1)->get();
     $jobtypes = JobType::orderBy('name','ASC')->where('status',1)->get();
    return view('front.account.job.create',[
      'categories' => $categories,
      'jobtypes' => $jobtypes
    ]);
   }

   public function savejob(Request $request){
      $rules = [
         'title' => 'required',
         'category' => 'required',
         'jobtype' => 'required',
         'vacancy' => 'required|integer',
         'location' => 'required',
         'description' => 'required',
         'company_name' => 'required|max:50',
      ];
      $validator = Validator::make($request->all(),$rules);

      if($validator->passes()){
        
         $job = new Job();
         $job->title = $request->title;
         $job->category_id = $request->category;
         $job->job_type_id = $request->jobtype;
         $job->user_id = Auth::user()->id;
         $job->vacancy = $request->vacancy;
         $job->location = $request->location;
         $job->description = $request->description;
         $job->benefits = $request->benefits;
         $job->responsibility = $request->responsibility;
         $job->qualifications = $request->qualifications;
         $job->experience = $request->experience;
         $job->company_name = $request->company_name;
         $job->company_location = $request->company_location;
         $job->company_website = $request->company_website;
         $job->save();
        
    session()->flash('status','Job added successfully');

    return response()->json([
      'status' => true,
      'errors' => []
   ]);

   }else{
      return response()->json([
         'status' => false,
         'errors' => $validator->errors()
      ]);
   }
}
public function myjob(){
   $jobs = Job::where('user_id',Auth::user()->id)->with('jobType')->paginate(10);
   return view('front.account.job.my-job',[
      'jobs' => $jobs
   ]);
}
}
