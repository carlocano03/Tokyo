<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;

class Member_registration extends Controller
{
    //
    public function applicationsx(Request $request)
    {
        $request->validate([
            'lastname' => 'required',
            'middlename' => 'required',
            'firstname' => 'required',
            'date_birth' => 'required',
        ]);
        
        Member::create($request->post());

        return redirect()->route('companies.index')->with('success','Company has been created successfully.');
    }
}
