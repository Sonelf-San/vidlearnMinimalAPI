<?php

namespace App\Http\Controllers\Admin;

use App\Models\Partners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partners::orderBy('id', 'DESC')->paginate(20);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:191',
            'description' => 'required',
            'link'   => 'nullable|string|max:191|url',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date'
        ]);

        // Checking the two dates
        $validator->after(function ($validator) use ($request) {
            //
            if ($request->end_date < $request->start_date) {
                $validator->errors()->add('end_date',
                    __('La date de fin doit etre plus grande que celle de début!'));
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $partner = new Partner();
        $partner->name = $request->name;
        $partner->link = $request->link;
        $partner->start_date = $request->start_date;
        $partner->end_date = $request->end_date;
        $partner->description = $request->description;
        $partner->save();
        session()->flash('success', 'partner created successfully');
        return redirect()->route('admin.partners.show', $partner->id);
    }

    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.show', compact('partner'));
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:191',
            'description' => 'required',
            'link'   => 'nullable|string|max:191|url',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
        ]);

        // Checking the two dates
        $validator->after(function ($validator) use ($request) {
            //
            if ($request->end_date < $request->start_date) {
                $validator->errors()->add('end_date',
                    __('La date de fin doit etre plus grande que celle de début!'));
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $partner->name = $request->name;
        $partner->link = $request->link;
        $partner->start_date = $request->start_date;
        $partner->end_date = $request->end_date;
        $partner->description = $request->description;
        $partner->save();
        session()->flash('success', 'Partners updated successfully');
        return redirect()->route('admin.partners.show', $partner->id);
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        session()->flash('success', 'Partners deleted successfully');
        return redirect()->route('admin.partners.index');
    }
}
