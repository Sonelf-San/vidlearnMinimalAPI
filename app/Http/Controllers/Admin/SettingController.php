<?php

namespace App\Http\Controllers\Admin;

// use App\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = settings()->all($fresh = true);
        return view('admin.settings', compact('settings'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'contact_email'     => 'required|email|max:191',
            'contact_phone'     => 'required|max:191',
            'post'              => 'required|max:191',
            'zip_code'          => 'required|string|max:191',
            'address'           => 'required|string|max:191',
            'local'             => 'required|string|max:10'
        ]);

        settings()->set([
            'contact_email'     => $request->contact_email,
            'contact_phone'     => $request->contact_phone,
            'post'              => $request->post,
            'zip_code'          => $request->zip_code,
            'address'           => $request->address,
            'local'             => $request->local
        ]);

        session()->flash('success', "Settings updated successfully");
        return redirect()->back();
    }
}
