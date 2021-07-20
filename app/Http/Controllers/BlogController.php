<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $blogs = Blog::where('user_id', $user->id)->get();

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        $validater = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        $user = Auth::user();

        if ($validater->fails()) {
            return response()->json(['success', true, 'errors' => $validater->errors()], 422);
        }

        $blog = new Blog();
        if ($request->hasFile('image')) {
            $img = $request->image;
            $filename = $img->getClientOriginalName();
            $imageUrl = Storage::putFileAs('/public/images', $request->file('image'), $filename);
        }
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->image = $imageUrl;
        $blog->description = $request->description;
        $blog->tags = $request->tags;
        $blog->user_id = $user->id;
        $blog->save();

        return response(['success' => true, 'message' => 'blog created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        // dd($blog);
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $user = Auth::user();




        if ($request->hasFile('image')) {
            $img = $request->image;
            $filename = $img->getClientOriginalName();
            $imageUrl = Storage::putFileAs('/public/images', $request->file('image'), $filename);
            $blog->image = $imageUrl;
        }
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->description = $request->description;
        $blog->tags = $request->tags;
        $blog->user_id = $user->id;
        $blog->save();

        return redirect('/blogs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);

        $blog->delete();

        return back()->with('message', 'blog deleted');
    }
}
