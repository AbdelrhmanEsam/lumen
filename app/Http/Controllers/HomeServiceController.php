<?php

namespace App\Http\Controllers;

use App\Models\HomeService;
use Illuminate\Http\Request;
use App\Http\Helper\ResponseBuilder;

class HomeServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $msg = 'All Services' ;
        $status = true;
        $data =  HomeService::all();

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $service = new HomeService;
        $service->title = $request->input('title');
        $service->description = $request->input('description');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(app()->basePath('public/images/home/services'), $imageName);
            $service->image = $imageName;
        }

        $service->save();

        if($service){
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
         $job = HomeService::where('id',$id)->first();
        if (!$job) {
            return ResponseBuilder::result('Job not found', false, null, 404);
        }
       return HomeService::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $service = HomeService::where('id',$request->id)->first();

        if (!$service) {
            return ResponseBuilder::result('Service not found', false, null, 404);
        }

        if ($request->hasFile('image')) {
            $this->deleteOldImage($service->image);
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(app()->basePath('public/images/home-services'), $imageName);
            $service->image = $imageName;
        }

        $service =  HomeService::findOrFail($request->id)->update(
        [
            "id" => $request->input('id'),
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            "image" => $service->image,
        ]);

        $msg = 'Updated successfully';
        $status = true;
        $data = $request->all();
        return ResponseBuilder::result($msg, $status, $data);
    }

    //  Function to delete old image
    private function deleteOldImage($imageName)
    {
        $imagePath = app()->basePath('public/images/home-services') . '/' . $imageName;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = HomeService::find($id);

        if (!$service) {
            return ResponseBuilder::result('Service not found', false, null, 404);
        }

        //  Delete the associated image
        $this->deleteOldImage($service->image);

        $service->delete();

        $msg = 'Deleted successfully';
        $status = true;

        return ResponseBuilder::result($msg, $status);
    }
}
