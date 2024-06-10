<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $search = [
        'q'      => '',
        'status' => '',
        'limit'  => 10
    ];

    public function index(Request $request)
    {
        $search = $this->search;
        $positions = new Position();

        if ($request->get('q')) {
            $search['q'] = $request->get('q');
            $positions = $positions->where('name', 'like', '%' . $search['q'] . '%');
        }

        if ($request->get('limit')) {
            $search['limit'] = $request->get('limit');
        }

        $positions = $positions->orderBy('name', 'asc')->paginate($search['limit']);
        $limits = [10, 20, 50];
        return view('admin.positions.index',
            compact('positions', 'search', 'limits'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.positions.create');
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
            'name' => 'required|max:191'
        ]);

        $position = Position::onlyTrashed()->where('name', $request->name)->first();
        if ($position) {
            $position->restore();
        } else {
            request()->validate([
                'name' => 'unique:positions'
            ]);

            $position = Position::create([
                'name' => $request->name
            ]);
        }

        session()->flash('success', 'Position Created successfully');
        return redirect(route('admin.positions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $position = Position::findOrFail($id);
        // return view('admin.positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::findOrFail($id);
        return view('admin.positions.edit', compact('position'));
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
        $position = Position::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        $validator->after(function ($validator) use ($request, $position) {
            $ex_new = Position::where('name', $request->name)->first();
            if ($ex_new && $ex_new->id !== $position->id) {
                $validator->errors()->add('name', 'This name is already taken');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $position = Position::findOrFail($id);

        $position->name = $request->get('name');
        $position->save();

        session()->flash('success', 'Position Updated successfully');
        return redirect()->route('admin.positions.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();
        session()->flash('success', 'Position Deleted Successfully');
        return redirect()->route('admin.positions.index');
    }
}
