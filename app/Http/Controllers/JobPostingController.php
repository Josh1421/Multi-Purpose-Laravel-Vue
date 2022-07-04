<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    
    public function index()
    {
        $posting = JobPosting::all();
        return view("job_posting.index", compact('posting'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $data = request()->validate([
            'job_name' => 'required',
            'job_description' => 'required',
            'vacants' => 'required'
        ]);

        $posting = JobPosting::create($data);

        return response()->json([
            'message' => 'Job Posting has been successfully saved',
            'data' => $posting
        ]);
    }

    
    public function show(JobPosting $jobPosting)
    {

    }

    
    public function edit($editSelectedId, Request $request)
    {
        $data = request()->validate([
            'job_name' => 'required',
            'job_description' => 'required',
            'vacants' => 'required'
        ]);

        $posting = JobPosting::where('id', $editSelectedId)->update($data);

        return response()->json([
            'message' => 'Job Posting has been successfully saved',
            'data' => $posting
        ]);
    }

    public function update(Request $request, JobPosting $jobPosting)
    {
        //
    }

    public function destroy($post_id)
    {
        $find_post = JobPosting::find($post_id)->delete();
        return response()->json([
            'message' => 'Record Deleted'
        ]);
    }
}
