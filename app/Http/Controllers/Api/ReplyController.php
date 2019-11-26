<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Topic;
use App\Http\Requests\Api\ReplyRequest;
use App\Http\Resources\ReplyResource;
use Mockery\Exception;


class ReplyController extends Controller
{
    // 创建回复
    public function store(ReplyRequest $request,Topic $topic,Reply $reply){
        $reply->content = $request->content;
        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();
        return new ReplyResource($reply);
    }

    //删除回复
    public function destroy(Topic $topic,Reply $reply){
        if ($reply->topic_id != $topic->id){
            abort(404);
        }
        try{
            $this->authorize('destroy',$reply);
        }catch(\Exception $e){
            abort(403,'没有操作权项');
        }
        $reply->delete();
        return response(null,204);
    }
}
