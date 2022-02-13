<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Utilities\UploadFiles;

class BannerController extends Controller
{
    private $uploadPath = './uploads/banners/';
    private $uploadFiles;

    public function __construct(UploadFiles $uploadFiles)
    {
        $this->uploadFiles = $uploadFiles;
    }

    public function index()
    {
        $banners = Banner::all();
        return response()->json($banners);
    }

    public function show($id)
    {
        $banner = Banner::find($id);
        return response()->json($banner);
    }

    public function store(Request $request)
    {
        $this->validate($request, ['path' => 'required', 'type' => 'required']);
        if (!$request->hasFile('path')) {
            return response()->json(['error' => 'No file selected'], 400);
        }
        $banner = new Banner();
        $file = $request->file('path');

        $pathName = $this->uploadFiles->upload($file, $this->uploadPath);

        $banner->path = $pathName;
        $banner->type =  $request->input('type');
        $banner->link = $request->input('link');
        ;
        $banner->save();

        return response()->json($banner);
    }

    public function update(Request $request, $id)
    {
        $Banner = Banner::find($id);

        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $pathName = $this->uploadFiles->update($file, $this->uploadPath, $Banner->path);
            $Banner->path = $pathName;
            $Banner->type =  $request->input('type') ?: $Banner->type;
        }
        $Banner->link = $request->input('link') ?: $Banner->link;
        $Banner->active = $request->input('active') ?: $Banner->active;
        $Banner->save();
        return  response()->json(["success" => "Banner updated successfully"]);
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json(['error' => 'Banner not found'], 404);
        }
        $this->uploadFiles->delete($banner->path);
        $banner->delete();
        return response()->json(['success' => 'Banner deleted']);
    }
}
