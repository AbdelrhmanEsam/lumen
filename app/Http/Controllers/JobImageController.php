<?php

namespace App\Http\Controllers;

use App\Models\JobImage;
use Illuminate\Http\Request;
use App\Http\Helper\ResponseBuilder;

class JobImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $msg = 'All Images' ;
        $status = true;
        $data =  JobImage::all();

        return ResponseBuilder::result($msg , $status , $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);


        // $job = new JobImage;
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = rand(99999, 9999999) . time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(app()->basePath('public/images/job'), $imageName);
        //     $job->image = $imageName;
        //  }
        //  $job->save();
        // if($job){
        //     $msg = ('Added successfully');
        //     $status = true;
        // }else{
        //     $msg = ('Somthing Error');
        //     $status = false;
        // }
        // $data = $request->all();
        // return ResponseBuilder::result($msg , $status , $imageName);




        // $job = new JobImage;
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->store('public/team') ;
        //     $job->image = $imageName;
        //  }

        // $ImageName = "";

        // if ($request->hasfile('image')) {
		// 	//videos file
		// 	$ImageName = rand(99999, 9999999) . time() . '.' . $request->image->getClientOriginalExtension();
		// 	$request->image->move(base_path('uploads/photos'), $ImageName);
		// }

        // if ($request->hasfile('files')) {
 		// 	foreach ($request->file('files') as $file) {
 		// 		$name = $file->getClientOriginalName();
		// 		$extention = $file->getClientOriginalExtension();
		// 		$imageName = rand(9999, 999999) . time() . "_albums" . '.' . $file->getClientOriginalExtension();
		// 		$file->move(base_path('uploads/photos/albums'), $imageName);
 		// 		JobImage::create([
		// 			'image' =>  $imageName,
 		// 		]);
		// 	}
		// }

        $ImageName = "";

        if ($request->hasfile('image')) {
            //videos file
            $ImageName = rand(99999, 9999999) . time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(app()->basePath('public/storage/photos'), $ImageName);
        }

         $jobs = JobImage::create([

            'image' => $ImageName,
         ]);

         return response()->json([
            'message' => 'Photos Save Successfully!!',
            'photos' => $jobs,
        ]);
        // $path = $request->file('image')->store('images');
        // $job = new JobImage;
        // $job->image = request()->file('image')->store('team');
        // $job->save();
        // return response()->json(['path' => $job]);


        // if($job){
        //     $msg = ('Added successfully');
        //     $status = true;
        // }else{
        //     $msg = ('Somthing Error');
        //     $status = false;
        // }
        // $data = $request->all();
        // return ResponseBuilder::result($msg , $status , $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobImage  $jobImage
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $image = JobImage::find($id);

        if (!$image) {
            return ResponseBuilder::result('Image not found', false, null, 404);
        }

        // Optional: Delete the associated image
        $this->deleteOldImage($image->image);

        $image->delete();

        $msg = 'Deleted successfully';
        $status = true;

        return ResponseBuilder::result($msg, $status);
    }

    //  Function to delete old image
    private function deleteOldImage($imageName)
    {
        $imagePath = app()->basePath('public/images/job') . '/' . $imageName;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}
