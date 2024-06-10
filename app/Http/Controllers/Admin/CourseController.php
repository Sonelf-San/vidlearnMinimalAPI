<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\ArtFile;
use App\Models\Category;
use App\Models\Logo;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Course::orderBy('created_at', 'DESC')->paginate(20);
//        return response()->json($articles);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $logos = Logo::all();
//        return view('admin.articles.create', compact('categories'));
        return view('admin.articles.create', compact('categories', 'logos'));
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
            'title'          => 'required|max:191',
            'description'   => 'required',
            'category' => 'required',
            'link'    => 'nullable|string|max:255',
//            'link'    => 'nullable|string|max:255|url',
        ]);

        $article = new Course();
        $article->title = $request->title;
        $article->slug = Str::slug($request->title, '-');
        // $article->slug = Str::slug($request->title, '-') . '-' . time();
        $article->description = $request->description;
        $article->category_id = $request->category;
        $article->logo_id = $request->logo;
        $article->link = $request->link;
        $article->user_id = Auth('admin')->user()->id;
        $article->save();

        session()->flash('success', 'Course created successfully');

        return redirect()->route('admin.articles.show', $article->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Course::findOrFail($id);
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Course::findOrFail($id);
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $logos = Logo::orderBy('created_at', 'DESC')->get();
        return view('admin.articles.edit', compact('article', 'categories', 'logos'));
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
        $article = Course::findOrFail($id);

        request()->validate([
            'title'          => 'required|max:191',
            'description'   => 'required',
            'category' => 'required',
            'link'    => 'nullable|string|max:255',
//            'link'    => 'nullable|string|max:255|url',
        ]);

        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->logo_id = $request->logo;
        $article->link = $request->link;
        $article->description = $request->description;
        $article->save();
        session()->flash('success', 'Course updated successfully');

        return redirect()->route('admin.articles.show', $article->id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Course::findOrFail($id);
        $article->delete();

        session()->flash('success', 'Course deleted successfully');
        return redirect()->route('admin.articles.index');
    }
}
