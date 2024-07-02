<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index(Request $request){
      $categories = Category::where('status',1)->get();
      $jobTypes = JobType::where('status',1)->get();
      $jobs= Job::where('status',1);
      
if(!empty($request->keyword)){
    $jobs= $jobs->where(function($query) use($request){
        $query->orWhere('title', 'like', '%'.$request->keyword.'%');
        $query->orWhere('keywords', 'like', '%'.$request->keyword.'%');
    });
}


if(!empty($request->location)){
    $jobs= $jobs->where('location', $request->location);    
}

if(!empty($request->category)){
    $jobs= $jobs->where('category_id', $request->category);    
}

$jobTypeArray = [];
// Search using Job Type
if(!empty($request->jobType)) {
    $jobTypeArray = explode(',',$request->jobType);

    $jobs = $jobs->whereIn('job_type_id',$jobTypeArray);
}

if(!empty($request->experience)){
    $jobs= $jobs->where('experience', $request->experience);    
}

$jobs = $jobs->with(['jobType','category']);

    if($request->sort == '0') {
        $jobs = $jobs->orderBy('created_at','ASC');
    } else {
        $jobs = $jobs->orderBy('created_at','DESC');
    }


$jobs= $jobs->with('jobType')->orderBy('created_at','DESC')->paginate(6);

return view('front.jobs',[
    'categories' => $categories,
    'jobTypes' => $jobTypes,
    'jobs' => $jobs,
    'jobTypeArray' => $jobTypeArray
]);
    }

    public function detail($id) {
        $job = Job::where([
            'id' => $id, 
            'status' => 1
        ])->with(['jobType','category'])->first();

if ($job == null) {
abort(404);
}

// $count = 0;
// if (Auth::user()) {
// $count = SavedJ::where([
// 'user_id' => Auth::user()->id,
// 'job_id' => $id
// ])->count();
// }


// fetch applicants

// $applications = JobApplication::where('job_id',$id)->with('user')->get();


return view('front.jobDetail',['job' => $job]);
}
}
