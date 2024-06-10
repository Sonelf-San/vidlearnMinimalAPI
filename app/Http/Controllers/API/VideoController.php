<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Video;

class VideoController extends Controller
{
/*    /**
     * Upload video for the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $connected = @fsockopen("www.google.com", 80);//Checking internet availability first
        if ($connected) {
            $course = Course::findOrFail($id);
            if(!$course){
                $data = [
                    'status' => 404,
                    'message' => 'Error, course not found',
                ];
                return response()->json($data, 404);
            }
            else
            {
                request()->validate([
                    'name'          => 'nullable|string',
                    'video' => 'required|mimes:mp4,avi,mov,ogg,webm',
                    'description'   => 'nullable',
                ]);
                $video = new Video();
                $video->name = $request->name;
                $video->course_id = $course->id;
                $video->video = $request->video;
                $video->description = $request->description;
                if($request->file('video'))
                {
                    //Getting the file name with extension
                    $image = $request->file('video');
                    $filenameWithExt = $image->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    $pat = $image->storeAs('public/Videos', $fileNameToStore);
                    $video->video = $fileNameToStore;
                }
                $video->save();
                $data = [
                    'status' => 200,
                    'video' => $video,
                    'message' => 'Video upload successfully awaiting for validation',
                ];
                return response()->json($data, 200);
            }
            fclose($connected);
        }
        else {
            return response()->json([
                'message' => 'Your do not have an internet connection, please try again later',
                'status' => 500,
            ]);

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        Storage::delete('public/Videos/'. $video->video);
        $video->delete();
        $data = [
            'status' => 200,
            'message' => 'Video deleted successfully',
        ];
        return response()->json($data, 200);
    }
}
