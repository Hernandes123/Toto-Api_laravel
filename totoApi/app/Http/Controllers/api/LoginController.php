<?php

namespace App\Http\Controllers\api;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
  
    public function index()
    {
        return User::all();
    }

 
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        User::create($request->all());
    }

 
    public function show($id)
    {
        return User::FindOrFail($id);
    }

   
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        $login = User::FindOrFail($id);
        $login->update($request->all());
    }

   
    public function destroy($id)
    {
        $login = User::FindOrFail($id);
        $login->delete();
        
    }


}
