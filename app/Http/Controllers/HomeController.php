<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){

$categories = Category::where('status',1)->orderBy('name','ASC')->take(8)->get();
$newCategories = Category::where('status',1)->orderBy('name','ASC')->get();
$jobs = Job::where('status',1)->where('isFetured',1)->orderBy('created_at','DESC')->with('jobType')->take(6)->get();
$latestjobs = Job::where('status',1)->orderBy('created_at','DESC')->with('jobType')->take(6)->get();

        return view('front.home',[
            'categories' => $categories,
            'jobs' => $jobs,
            'latestjobs' => $latestjobs,
            'newCategories' => $newCategories
         ]);
    }
}
