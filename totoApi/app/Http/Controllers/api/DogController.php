<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dog;

class DogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dog::all();
    }

    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        Dog::create($request->all());
    }

    public function show($id)
    {
        return Dog::FindOrFail($id);
    }

   
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $dog = Dog::FindOrFail($id);
        $dog->update($request->all());
    }


    public function destroy($id)
    {
        //
    }
}
