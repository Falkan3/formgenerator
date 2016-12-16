<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\User;
use Auth;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($offset = 0)
    {
        //return Auth::user()->photos->offset($offset)->limit(6);
        return Photo::where('user_id', Auth::user()->id)->offset($offset)->limit(6)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('REST.photos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $extension = $file->extension();
        $user = User::findOrFail($request['user_id']);

        if ($file->isValid()) {
            if ($file->getSize() < 350000) {
                if (substr($file->getMimeType(), 0, 5) == 'image') {
                    if (!file_exists('user_photos/' . $user->name . "/Photos/")) {
                        mkdir('user_photos/' . $user->name . "/Photos/", 0777, true);
                    }
                    $file->move('user_photos/' . $user->name . "/Photos/", md5($name . date('l jS F Y h:i:s A')) . "." . $extension);

                    $new = new Photo;
                    $new->user_id = $request['user_id'];
                    $new->name = substr($name, 0, 25);
                    $new->title = substr($request['title'], 0, 25);
                    $new->comment = substr($request['comment'], 0, 150);
                    $public = $request['public'];
                    if (is_null($public))
                        $new->public = 0;
                    else
                        $new->public = 1;
                    $new->location = 'user_photos/' . $user->name . "/Photos/" . md5($name . date('l jS F Y h:i:s A')) . "." . $extension;
                    $new->save();

                    return redirect('/home')->withErrors(["Successfully uploaded image"]);
                } else {
                    return back()->withErrors(["File isn't an image"]);
                }
            } else {
                return back()->withErrors(["File is too big (max 350000 B)"]);
            }
        } else
            return back()->withErrors(["File is invalid"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::user()->id;
        $photo = Photo::where('id', $id)->where('user_id', $user_id)->get();
        return view('REST.photos.show', ['photo' => $photo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        return view('REST.photos.edit', ['photo' => $photo]);
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
        $file = $request->file('image');
        if (isset($file)) {
            $name = $file->getClientOriginalName();
            $extension = $file->extension();
        }
        $user = User::findOrFail($request['user_id']);

        $new = Photo::findOrFail($id);
        $new->user_id = $request['user_id'];
        $new->title = substr($request['title'], 0, 25);
        $new->comment = substr($request['comment'], 0, 150);
        $public = $request['public'];
        if (is_null($public))
            $new->public = 0;
        else
            $new->public = 1;
        if (isset($file)) {
            if ($file->isValid()) {
                if ($file->getSize() < 350000) {
                    if (substr($file->getMimeType(), 0, 5) == 'image') {
                        if (!file_exists('user_photos/' . $user->name . "/Photos/")) {
                            mkdir('user_photos/' . $user->name . "/Photos/", 0777, true);
                        }
                        $new->name = substr($name, 0, 25);
                        $file->move('user_photos/' . $user->name . "/Photos/", md5($name . date('l jS F Y h:i:s A')) . "." . $extension);

                        try {
                            //Destroy old image
                            if (file_exists($new->location)) unlink($new->location);
                        } catch (\Exception $ex) {

                        }

                        $new->location = 'user_photos/' . $user->name . "/Photos/" . md5($name . date('l jS F Y h:i:s A')) . "." . $extension;
                    } else {
                        return back()->withErrors(["File isn't an image"]);
                    }
                } else {
                    return back()->withErrors(["File is too big (max 350000 B)"]);
                }
            }
        }
        $new->save();
        return redirect('/home')->withErrors(["Successfully edited image"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $photo = Photo::findOrFail($id);
            Photo::destroy($id);
            if (file_exists($photo->location)) unlink($photo->location);

            return redirect('/home')->withErrors(["Successfuly deleted image"]);
        } catch (\Exception $ex) {
            return redirect('/home')->withErrors(["Error deleting image"]);
        }
    }
}
