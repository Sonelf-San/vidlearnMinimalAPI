<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /*    /**
     * Post comment for the specified course.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function courseCommentStore(Request $request, $id)
    {
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
                'content'          => 'required|string',
            ]);
            $comment = new Comment();
            $comment->content = $request->content;
            $comment->course_id = $course->id;
            $comment->user_id= Auth::user()->id;
            $comment->save();
            $data = [
                'status' => 200,
                'comment' => $comment,
                'user_id' =>$comment->user_id,
                'course_id' => $comment->course_id,
                'message' => 'Comment posted successfully',
            ];
            return response()->json($data, 200);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function courseCommentDestroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        $data = [
            'status' => 200,
            'message' => 'Comment deleted successfully',
        ];
        return response()->json($data, 200);
    }




    /*    /**
 * Post comment for the specified video resource.
 *
 * @param  \Illuminate\Http\Request $request
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
    public function videoCommentStore(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        if(!$video){
            $data = [
                'status' => 404,
                'message' => 'Error, video not found',
            ];
            return response()->json($data, 404);
        }
        else
        {
            request()->validate([
                'content' => 'required|string',
            ]);
            $comment = new Comment();
            $comment->content = $request->content;
            $comment->video_id = $video->id;
            $comment->user_id= Auth::user()->id;
            $comment->save();
            $data = [
                'status' => 200,
                'comment' => $comment,
                'user_id' => $comment->user_id,
                'video_id' => $comment->video_id,
                'message' => 'Comment posted successfully',
            ];
            return response()->json($data, 200);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function videoCommentDestroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        $data = [
            'status' => 200,
            'message' => 'Comment deleted successfully',
        ];
        return response()->json($data, 200);
    }



}
