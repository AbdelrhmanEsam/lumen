<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Helper\ResponseBuilder;
use Illuminate\Http\UploadedFile;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $msg = 'All Services' ;
        $status = true;
        $data =  Service::all();

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

        $service = new Service;
        $service->title = $request->input('title');
        $service->description = $request->input('description');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(app()->basePath('public/images/services'), $imageName);
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
        $service = Service::where('id',$id)->first();
        if (!$service) {
            return ResponseBuilder::result('Service not found', false, null, 404);
        }

       return Service::findOrFail($id);
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

        $service = Service::where('id',$request->id)->first();

        if (!$service) {
            return ResponseBuilder::result('Service not found', false, null, 404);
        }

        if ($request->hasFile('image')) {
            $this->deleteOldImage($service->image);
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(app()->basePath('public/images/services'), $imageName);
            $service->image = $imageName;
        }

        $service =  Service::findOrFail($request->id)->update(
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



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return ResponseBuilder::result('Service not found', false, null, 404);
        }

        // Optional: Delete the associated image
        $this->deleteOldImage($service->image);

        $service->delete();

        $msg = 'Deleted successfully';
        $status = true;

        return ResponseBuilder::result($msg, $status);
    }

    //  Function to delete old image
    private function deleteOldImage($imageName)
    {
        $imagePath = app()->basePath('public/images/services') . '/' . $imageName;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}
