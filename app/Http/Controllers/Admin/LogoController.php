<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Logo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LogoController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logos = Logo::orderBy('created_at', 'DESC')->paginate(20);
        return view('admin.logos.index', compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.logos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name'          => 'required|max:191',
            'image'         => 'required|mimes:jpg,png,svg'
        ]);

        $logo = new Logo();
        $logo->name = $request->name;

        if($request->file('image'))
        {
            //Getting the file name with extension
            $image = $request->file('image');
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $pat = $image->storeAs('public/logos', $fileNameToStore);
            $logo->image = $fileNameToStore;
        }

        // dd($logo);
        $logo->save();
        session()->flash('success', 'logo created successfully');

        return redirect()->route('admin.logos.show', $logo->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $logo = Logo::findOrFail($id);
        return view('admin.logos.show', compact('logo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $logo = Logo::findOrFail($id);
        return view('admin.logos.edit', compact('logo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $logo = Logo::findOrFail($id);

        request()->validate([
            'name'          => 'required|max:191',
            'image'         => 'nullable|mimes:jpg,png,svg'
        ]);

        $logo->name = $request->name;
        if($request->file('image')) {
            if ($logo->image) {
                Storage::delete('public/logos/'. $logo->image);
            }
            //Getting the file name with extension
            $image = $request->file('image');
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $pat = $image->storeAs('public/logos', $fileNameToStore);
            $logo->image = $fileNameToStore;
        }

        $logo->save();
        session()->flash('success', 'logo updated successfully');

        return redirect()->route('admin.logos.show', $logo->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $logo = Logo::findOrFail($id);
        Storage::delete('public/logos/'. $logo->image);
        $logo->delete();

        session()->flash('success', 'logo deleted successfully');
        return redirect()->route('admin.logos.index');
    }
}
