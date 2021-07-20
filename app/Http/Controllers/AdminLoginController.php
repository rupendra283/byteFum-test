<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('admin.auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        // dd($request->all());
        $credentials = $request->only('email', 'password');
        // Attempt to log the user in
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            // dd(Session::all());
            // if successful, then redirect to their intended location
            return redirect()->intended(route('admin.home'));
        }

        // if unsuccessful, then redirect back to the login with the form data
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function home()
    {
        return view('admin.home');
    }

    public function blogs()
    {
        $blogs = Blog::with('user')->withTrashed()->get();
        // dd($blogs);
        return view('admin.blogs', compact('blogs'));
    }

    public function deleteBlog($slug)
    {
        $blog = Blog::withTrashed()->where('slug', $slug)->first();
        $blog->forceDelete();

        return back()->with('message', 'blog deleted permenently');
    }
}
