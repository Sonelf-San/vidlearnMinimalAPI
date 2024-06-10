<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
        $categories = new Category();

        if ($request->get('q')) {
            $search['q'] = $request->get('q');
            $categories = $categories->where('name', 'like', '%' . $search['q'] . '%');
        }

        if ($request->get('limit')) {
            $search['limit'] = $request->get('limit');
        }

        $categories = $categories->orderBy('name', 'asc')->paginate($search['limit']);
        $limits = [10, 20, 50];
        return view('admin.categories.index',
            compact('categories', 'search', 'limits'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.categories.create');
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

        $new = Category::onlyTrashed()->where('name', $request->name)->first();
        if ($new) {
            $new->restore();
        } else {
            request()->validate([
                'name' => 'unique:categories'
            ]);

            $new = Category::create([
                'name' => $request->name
            ]);
        }

        session()->flash('success', 'Category Created successfully');
        return redirect(route('admin.categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
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
        $new = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        $validator->after(function ($validator) use ($request, $new) {
            $ex_new = Category::where('name', $request->name)->first();
            if ($ex_new && $ex_new->id !== $new->id) {
                $validator->errors()->add('name', 'This name is already taken');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $new = Category::findOrFail($id);

        $new->name = $request->get('name');
        $new->save();

        session()->flash('success', 'Category Updated successfully');
        return redirect()->route('admin.categories.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new = Category::findOrFail($id);
        $new->delete();
        session()->flash('success', 'Category Deleted Successfully');
        return redirect()->route('admin.categories.index');
    }
}
