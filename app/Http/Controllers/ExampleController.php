<?php

namespace App\Http\Controllers;

use App\Models\User;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function test(){
        echo 'Test Lumen ! Done';
    }

    public function usres()
    {
        return User::all();
    }
}
