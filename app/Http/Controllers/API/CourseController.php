<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
//        $courses = Course::all();
//        $courses = Course::orderBy('created_at', 'DESC')->paginate(20);
        $courses = Course::with('logo', 'category')->get();
        $courses->each(function($course) {
            $course->logo_url = $course->getLogoUrl();
            $course->category_name = $course->category->name;
        });

        if($courses->isEmpty()){
            $data = [
                'status' => 404,
                'message' => 'No record found',
            ];
            return response()->json($data, 404);
        }
        else
        {

            $data = [
                'status' => 200,
                'courses' => $courses
            ];
            return response()->json($data, 200);
        }

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required', 'description' => 'required',
        ]);
    }



    public function show($id)
    {
        $course = Course::findOrFail($id);
        $videos = $course->videos;
        $courseComments = $course->comments;

        $courComment = [];

        foreach ($courseComments as $comment) {
            $courComment[] = [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at,
                'course_id' => $comment->course_id,
            ];
        }

        $courseDetails = [
            'id' => $course->id,
            'name' => $course->name,
            'description' => $course->description,
        ];

        $videoData = [];

        foreach ($videos as $video) {
            $videoData[] = [
                'id' => $video->id,
                'user_id' => $video->user_id,
                'validated' => $video->validated,
                'name' => $video->name,
                'description' => $video->description,
                'video' => asset('storage/' . $video->video), // Ensure the URL is correct
            ];
        }

        $data = [
            'course' => $courseDetails,
            'videos' => $videoData,
            'courseComments' => $courComment,
        ];

        return response()->json($data, 200);
    }

//    public function show($id)
//    {
//        // Find the course by ID
//        $course = Course::findOrFail($id);
//
//        // Get the associated videos and comments
//        $videos = $course->videos;
//        $courseComments = $course->comments;
//
//        $courComment = [];
//
//        foreach ($courseComments as $comment) {
//            $courComment[] = [
//                'id' => $comment->id,
//                'content' => $comment->content,
//                'created_at' => $comment->created_at,
//                'course_id' => $comment->course_id,
//            ];
//        }
//
//        // Collect course details
//        $courseDetails = [
//            'id' => $course->id,
//            'name' => $course->name,
//            'description' => $course->description,
//        ];
//
//        // Initialize an array to store video data
//        $videoData = [];
//
//        // Iteration through the videos and collect necessary details
//        foreach ($videos as $video) {
//            $videoData[] = [
//                'id' => $video->id,
//                'user_id' => $video->user_id,
//                'validated' => $video->validated,
//                'name' => $video->name,
//                'description' => $video->description,
//                'video' => $video->video,
//            ];
//        }
//
//        // Combine course details and video data into a single array
//        $data = [
//            'course' => $courseDetails,
//            'videos' => $videoData,
//            'courseComments' => $courComment,
//        ];
//
//        // Return the data as a JSON response with a 200 status code
//        return response()->json($data, 200);
//    }

}
