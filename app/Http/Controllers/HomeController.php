<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PhotoController;
use Carbon\Carbon;
use Auth;
use App\Photo;
use App\Page;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!isset($request->offset))
            $offset = 0;
        else
            $offset = $request->offset;
        $photos = app('App\Http\Controllers\PhotoController')->index($offset);

        $one_week_ago = Carbon::now()->subWeeks(1);
        $lastweek = Photo::where('user_id', Auth::user()->id)->withTrashed()->where('created_at', '>=', $one_week_ago)->count();

        $photocount = Photo::all()->count();

        $pages = Page::all();

        return view('lte.demo', ['photos' => $photos, 'lastweek' => $lastweek, 'photocount' => $photocount, 'pages' => $pages, 'pagename' => 'Dashboard']);
    }

    public function PreviousPhoto(Request $request)
    {
        $offset = $request->input('offset');

        if($offset > 6)
        {
            $photos = app('App\Http\Controllers\PhotoController')->index($offset);
        }
        else
            $photos = app('App\Http\Controllers\PhotoController')->index();

        $one_week_ago = Carbon::now()->subWeeks(1);
        $lastweek = Photo::where('user_id', Auth::user()->id)->withTrashed()->where('created_at', '>=', $one_week_ago)->count();

        $photocount = Photo::all()->count();

        $pages = Page::all();

        return view('lte.demo', ['photos' => $photos, 'lastweek' => $lastweek, 'photocount' => $photocount, 'pages' => $pages, 'pagename' => 'Dashboard']);
    }

    public function NextPhoto(Request $request)
    {
        $offset = $request->input('offset');

        $photos = app('App\Http\Controllers\PhotoController')->index($offset);

        $one_week_ago = Carbon::now()->subWeeks(1);
        $lastweek = Photo::where('user_id', Auth::user()->id)->withTrashed()->where('created_at', '>=', $one_week_ago)->count();

        $photocount = Photo::all()->count();

        $pages = Page::all();

        return view('lte.demo', ['photos' => $photos, 'lastweek' => $lastweek, 'photocount' => $photocount, 'pages' => $pages, 'pagename' => 'Dashboard']);
    }
}
