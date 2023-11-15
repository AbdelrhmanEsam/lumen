<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Helper\ResponseBuilder;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $msg = 'All Jobs' ;
        $status = true;
        $data =  Job::all();

        return ResponseBuilder::result($msg , $status , $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'remote' => 'required|string',
        ]);

        $job = new Job;
        $job->title = $request->input('title');
        $job->description = $request->input('description');
        $job->type = $request->input('type');
        $job->remote = $request->input('remote');


        $job->save();

        if($job){
            $msg = ('Added successfully');
            $status = true;
        }else{
            $msg = ('Somthing Error');
            $status = false;
        }
        $data = $request->all();
        return ResponseBuilder::result($msg , $status , $data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $job = Job::where('id',$id)->first();
        if (!$job) {
            return ResponseBuilder::result('Job not found', false, null, 404);
        }
       return Job::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'remote' => 'required|string',

         ]);

        $job = Job::where('id',$request->id)->first();

        if (!$job) {
            return ResponseBuilder::result('job not found', false, null, 404);
        }



        $job =  Job::findOrFail($request->id)->update(
        [
            "id" => $request->input('id'),
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            "type" => $request->input('type'),
            "remote" => $request->input('remote'),
         ]);

        $msg = 'Updated successfully';
        $status = true;
        $data = $request->all();
        return ResponseBuilder::result($msg, $status, $data);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return ResponseBuilder::result('job not found', false, null, 404);
        }

        $job->delete();

        $msg = 'Deleted successfully';
        $status = true;

        return ResponseBuilder::result($msg, $status);
    }
}
