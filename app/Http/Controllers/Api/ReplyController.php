<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Topic;
use App\Http\Requests\Api\ReplyRequest;
use App\Http\Resources\ReplyResource;



class ReplyController extends Controller
{
    public function store(ReplyRequest $request,Topic $topic,Reply $reply){
        $reply->content = $request->content;
        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();
        return new ReplyResource($reply);
    }
    //
}
