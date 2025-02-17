<?php

namespace Modules\JobModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jobmodule::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobmodule::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('jobmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('jobmodule::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
