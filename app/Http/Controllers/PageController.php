<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Layout;
use Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($offset = 0)
    {
        return Page::offset($offset)->limit(6)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('REST.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->name;
        if(strlen($name)==0)
        {
            return back()->withErrors(["Name can't be empty"]);
        }
        $description = $request->description;
        $layout = $request->layout;
        $online = $request->online;

        $new = new Page;
        $new->name = substr($name, 0, 25);
        $new->description = $description;
        $new->layout = $layout;
        $new->online = $online;

        $new->save();

        return redirect('/home')->withErrors(["Successfully created new page"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('REST.pages.show', ['page' => $page]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $layouts = Layout::pluck('name', 'id');
        return view('REST.pages.edit', ['page' => $page, 'layouts' => $layouts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $name = $request->name;
        if(strlen($name)==0)
        {
            return back()->withErrors(["Name can't be empty"]);
        }
        $description = $request->description;
        $layout = $request->layout;
        $online = $request->online;

        $page->name = substr($name, 0, 25);
        $page->description = $description;
        $page->layout = $layout;
        $page->online = $online;

        $page->save();

        return redirect('/home')->withErrors(["Successfully applied changes to page"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id==1)
        {
            return redirect('/home')->withErrors(["Can't destroy index page"]);
        }
        try {
            Page::destroy($id);

            return redirect('/home')->withErrors(["Successfuly deleted page"]);
        } catch (\Exception $ex) {
            return redirect('/home')->withErrors(["Error deleting page"]);
        }
    }
}
