<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cookie;

class CookieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get Cookies List
        $cookies = Cookie::get();
        // dd($cookies);
        return view('cookie',[
            'best_cookie'=>'Snickerdoodles',
            'cookies' => $cookies
        ]);
    }

    /**
     * Return Cookies List API
     * 
     * @return JSON $cookies
     */
    public function get_cookies()
    {
        $cookies = Cookie::get();
        return response()->json([
            'message'   =>  'Cookie List',
            'status'    =>  'success',
            'cookies'   =>  $cookies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newCookie = new Cookie;
        $newCookie->title = $request->title;
        $newCookie->description = $request->description;
        $newCookie->save();
        return redirect('/cookie');
    }

    /**
     * Create Cookie API
     */
    public function create_cookie(Request $request)
    {
        $newCookie = new Cookie;
        $newCookie->title = $request->title;
        $newCookie->description = $request->description;
        $newCookie->save();
        return response()->json([
            'message'   =>  'Cookie Create',
            'status'    =>  'success',
            'cookies'   =>  $newCookie
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
