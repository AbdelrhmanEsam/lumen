<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Helper\ResponseBuilder;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $msg = 'All Massages' ;
        $status = true;
        $data =  ContactUs::all();

        return ResponseBuilder::result($msg , $status , $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'your_massage' => 'required|string',
        ]);

        $contactUs = new ContactUs;
        $contactUs->name = $request->input('name');
        $contactUs->email = $request->input('email');
        $contactUs->your_massage = $request->input('your_massage');
        $contactUs->save();

        $msg = ('Added successfully');
        $status = true;
        $data = $request->all();
        return ResponseBuilder::result($msg , $status ,$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactUs $contactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $contactUs)
    {
        //
    }
}
