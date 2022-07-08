<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Employee extends Controller
{
    //
    public function uploadAvatar(Request $request)
    {
        // dd($request->address);
        // dd(gettype($request->file('avatar')));
        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            // $filename= date('YmdHi').$file->getClientOriginalName();
            
            $interventionImage = Image::make($file)->resize(null, 600, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->stream("jpg", 100);
            $filePath = 'employee/images/avatar';
            $filename = $request->address.".jpg";
            if(!Storage::exists($filePath)) {
                Storage::makeDirectory($filePath, 0775, true); //creates directory
            }
            
            \Storage::put($filePath.'/'.$filename, $interventionImage, "public");
        } else {
            return response()->json(['status' => 'file_not_found'], 404);
        }
        return response()->json(['status' => 'success'], 200);
    }
    public function test(Request $request)
    {
        dd($request);
    }
    public function getAvatar(Request $request)
    {
        // $path = storage_path('public/' . $filename);

        // if (!File::exists($path)) {
        //     abort(404);
        // }
    
        // $file = File::get($path);
        // $type = File::mimeType($path);
    
        // $response = Response::make($file, 200);
        // $response->header("Content-Type", $type);
    
        // return $response;
        if (!$request->address) return response()->json(['status' => 'params_error'], 400);
        try
        {
            return Image::make(storage_path('app/employee/images/avatar/'.$request->address.'.jpg' ))->response();
        } catch (\Exception $e)
        {
            return response()->json(['status' => 'file_not_found'], 404);
        }

    }
}
