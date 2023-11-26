<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // $path = $request->file(key:"image")->store("awardImages","s3");
        $path = $request->file(key: "image")->storeAs("bannerImages",$request->file(key:"image")->getClientOriginalName(), "s3");
        $url = Storage::disk(name:'s3')->url($path);
        $image = new Image();
        $image->filename = $request->file(key:"image")->getClientOriginalName();
        $image->url = $url;
        $image->save();
        dd($url);
        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }
}
