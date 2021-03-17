<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comments;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        // get first all primary comments
        $prim_comments = Comments::orderBy('created_at', 'DESC')->whereNull('parent_comment_id')->get()->toArray();
        foreach ($prim_comments as $key => $value) {
            // format date
            $date = Carbon::parse($value['created_at']);
            $prim_comments[$key]['created_at'] = $date->format('F j, Y g:i a');

            // get all nested comments
            $sec_comments = Comments::where('parent_comment_id', $value['id'])->get()->toArray();
            if ($sec_comments) {
                foreach ($sec_comments as $key2 => $value2) {
                    // format date
                    $date2 = Carbon::parse($value2['created_at']);
                    $sec_comments[$key2]['created_at'] = $date2->format('F j, Y g:i a');
                }
                $prim_comments[$key]['sec'] = $sec_comments;
            }
        }
        
        return $prim_comments;
        // return CommentResource::collection($prim_comments);
    }

    public function store(Request $request)
    {
        // insert comment
        $comment = Comments::create($request->all());
        return $comment;
    }
}
