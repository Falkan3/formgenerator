<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::findOrFail(1);
        return view('pages.main', ['layout' => $page->getLayout->location]);
    }

    public function ViewPage($id)
    {
        $page = Page::findOrFail($id);
        return view($page->location, ['layout' => $page->getLayout->location]);
    }
}
