<?php

namespace App\Http\Controllers\API;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;


class AboutController extends Controller
{
    public function edit_about(){

        return About::orderBy('id','desc')->first();

    }

    public function update_about(Request $request, $id)
    {
        $about = About::find($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',

        ]);

        // $name = $about->photo;
        // if ($request->hasFile('photo')) {
        //     $photo = $request->file('photo');
        //     $name = time() . '.' . $photo->getClientOriginalExtension();
        //     $photo->move(public_path('/img/upload/'), $name);
        //     $name = '/img/upload/' . $name;
        // }
        // $namecv = $about->cv;
        // if ($request->hasFile('cv')) {
        //     $cv = $request->file('cv');
        //     $namecv = time() . '.' . $cv->getClientOriginalExtension();
        //     $cv->move(public_path('/cv/'), $namecv);
        //     $namecv = '/cv/' . $namecv;
        // }

        $name = '';
        if ($about->photo != $request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time().".".$ex;
            $img = Image::make($request->photo)->resize(200, 200);
            $upload_path = public_path()."/img/upload/";
            $image = $upload_path.$about->photo;
            $img->save($upload_path.$name);
            if (file_exists($image)) {
                @unlink($image);
            } else {
                $name = $about->photo;
            }
        }
        $namecv = '';
        if ($about->cv != $request->cv) {
            $strpos = strpos($request->cv, ';');
            $sub = substr($request->cv, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $namecv = time().".".$ex;
            $img = Image::make($request->cv)->resize(200, 200);
            $upload_path = public_path()."/img/upload/";
            $image = $upload_path.$about->cv;
            $img->save($upload_path.$namecv);
            if (file_exists($image)) {
                @unlink($image);
            } else {
                $namecv = $about->cv;
            }
        }

        $about->name = $request->name;
        $about->email = $request->email;
        $about->phone = $request->phone;
        $about->address = $request->address;
        $about->description = $request->description;
        $about->tagline = $request->tagline;
        $about->photo = $name;
        $about->cv = $namecv;
        $about->save();

        return response()->json(['message' => 'About updated successfully'], 200);
    }
}