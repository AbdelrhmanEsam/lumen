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
        //
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

        $job = new JobImage;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(app()->basePath('public/images/job'), $imageName);
            $job->image = $imageName;
        }

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
